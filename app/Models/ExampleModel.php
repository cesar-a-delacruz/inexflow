<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Record;

class ExampleModel extends Model
{
    protected $table = 'records';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = Record::class;

    protected $allowedFields = [
        'business_id',
        'description',
        'category',
        'amount',
        'subtotal',
        'transaction_id',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // ===========================================
    // MÉTODOS PARA REPORTES FINANCIEROS
    // ===========================================

    /**
     * Obtiene el Estado de Resultados para un período específico
     * 
     * @param string|null $businessId ID del negocio
     * @param array $filters Filtros de fecha y otros
     * @return array Estado de resultados con ingresos, gastos y utilidad
     */
    public function getIncomeStatement($businessId = null, array $filters = []): array
    {
        $builder = $this->builder();

        // Join con categorías para obtener el tipo
        $builder->select('
            categories.type,
            categories.name as category_name,
            SUM(records.amount) as total_amount,
            COUNT(records.id) as record_count
        ')
            ->join('categories', 'categories.business_id = records.business_id AND categories.category_number = records.category_number')
            ->groupBy('categories.type, categories.name');

        // Aplicar filtros
        $this->applyFilters($builder, $businessId, $filters);

        $results = $builder->get()->getResultArray();

        // Organizar datos por tipo
        $incomes = [];
        $expenses = [];
        $totalIncomes = 0;
        $totalExpenses = 0;

        foreach ($results as $row) {
            if ($row['type'] === 'income') {
                $incomes[] = [
                    'category' => $row['category_name'],
                    'amount' => (float) $row['total_amount'],
                    'count' => (int) $row['record_count']
                ];
                $totalIncomes += (float) $row['total_amount'];
            } elseif ($row['type'] === 'expense') {
                $expenses[] = [
                    'category' => $row['category_name'],
                    'amount' => (float) $row['total_amount'],
                    'count' => (int) $row['record_count']
                ];
                $totalExpenses += (float) $row['total_amount'];
            }
        }

        return [
            'period' => $this->getPeriodDescription($filters),
            'incomes' => $incomes,
            'expenses' => $expenses,
            'totals' => [
                'total_incomes' => $totalIncomes,
                'total_expenses' => $totalExpenses,
                'net_profit' => $totalIncomes - $totalExpenses,
                'profit_margin' => $totalIncomes > 0 ? (($totalIncomes - $totalExpenses) / $totalIncomes) * 100 : 0
            ]
            //profit_margin: ¿Qué porcentaje de tus ingresos se convierte en ganancias?; Un margen negativo indica que los gastos superan a los ingresos.
        ];
    }

    /**
     * Obtiene el Flujo de Caja agrupado por período
     * 
     * @param string|null $businessId ID del negocio
     * @param array $filters Filtros de fecha y agrupación
     * @return array Flujo de caja por período
     */
    public function getCashFlow($businessId = null, array $filters = []): array
    {
        $builder = $this->builder();

        // Determinar agrupación (día, semana, mes)
        $groupBy = $filters['group_by'] ?? 'day';
        $dateFormat = $this->getDateFormat($groupBy);

        $builder->select("
            DATE_FORMAT(records.record_date, '$dateFormat') as period,
            categories.type,
            SUM(records.amount) as total_amount,
            COUNT(records.id) as record_count
        ")
            ->join('categories', 'categories.business_id = records.business_id AND categories.category_number = records.category_number')
            ->groupBy('period, categories.type')
            ->orderBy('records.record_date', 'ASC');

        // Aplicar filtros
        $this->applyFilters($builder, $businessId, $filters);

        $results = $builder->get()->getResultArray();

        // Organizar datos por período
        $cashFlow = [];
        $runningBalance = $filters['initial_balance'] ?? 0;

        foreach ($results as $row) {
            $period = $row['period'];

            if (!isset($cashFlow[$period])) {
                $cashFlow[$period] = [
                    'period' => $period,
                    'incomes' => 0,
                    'expenses' => 0,
                    'net_flow' => 0,
                    'running_balance' => $runningBalance,
                    'record_count' => 0
                ];
            }

            if ($row['type'] === 'income') {
                $cashFlow[$period]['incomes'] += (float) $row['total_amount'];
            } elseif ($row['type'] === 'expense') {
                $cashFlow[$period]['expenses'] += (float) $row['total_amount'];
            }

            $cashFlow[$period]['record_count'] += (int) $row['record_count'];
        }

        // Calcular flujo neto y balance acumulado
        foreach ($cashFlow as $period => &$data) {
            $data['net_flow'] = $data['incomes'] - $data['expenses'];
            $runningBalance += $data['net_flow'];
            $data['running_balance'] = $runningBalance;
        }

        return [
            'period_type' => $groupBy,
            'period' => $this->getPeriodDescription($filters),
            'initial_balance' => $filters['initial_balance'] ?? 0,
            'final_balance' => $runningBalance,
            'total_periods' => count($cashFlow),
            'cash_flow' => array_values($cashFlow)
        ];
    }

    /**
     * Obtiene el resumen de gastos por categoría
     * 
     * @param string|null $businessId ID del negocio
     * @param array $filters Filtros de fecha y tipo
     * @return array Resumen por categorías
     */
    public function getCategoryAnalysis($businessId = null, array $filters = []): array
    {

        $builder = $this->builder();

        $builder->select('
            categories.type,
            categories.name as category_name,
            SUM(records.amount) as total_amount,
            COUNT(records.id) as record_count,
            AVG(records.amount) as average_amount,
            MIN(records.amount) as min_amount,
            MAX(records.amount) as max_amount
        ')
            ->join('categories', 'categories.business_id = records.business_id AND categories.category_number = records.category_number')
            ->groupBy('categories.type, categories.name')
            ->orderBy('total_amount', 'DESC');

        // Aplicar filtros
        $this->applyFilters($builder, $businessId, $filters);

        // Filtrar por tipo si se especifica
        if (!empty($filters['category_type'])) {
            $builder->where('categories.type', $filters['category_type']);
        }

        $results = $builder->get()->getResultArray();

        // Calcular totales para porcentajes
        $totalAmount = array_sum(array_column($results, 'total_amount'));

        // Formatear datos
        $categories = [];
        foreach ($results as $row) {
            $amount = (float) $row['total_amount'];
            $categories[] = [
                'type' => $row['type'],
                'category' => $row['category_name'],
                'amount' => $amount,
                'percentage' => $totalAmount > 0 ? ($amount / $totalAmount) * 100 : 0,
                'count' => (int) $row['record_count'],
                'average' => (float) $row['average_amount'],
                'min' => (float) $row['min_amount'],
                'max' => (float) $row['max_amount']
            ];
        }

        return [
            'period' => $this->getPeriodDescription($filters),
            'filter_type' => $filters['category_type'] ?? 'all',
            'total_amount' => $totalAmount,
            'total_records' => array_sum(array_column($results, 'record_count')),
            'categories' => $categories
        ];
    }

    /**
     * Obtiene métricas de rendimiento del negocio
     * 
     * @param string|null $businessId ID del negocio
     * @param array $filters Filtros de fecha
     * @return array Métricas de rendimiento
     */
    public function getBusinessMetrics($businessId = null, array $filters = []): array
    {
        $builder = $this->builder();

        $builder->select('
            categories.type,
            DATE_FORMAT(records.record_date, "%Y-%m") as month,
            SUM(records.amount) as total_amount,
            COUNT(records.id) as record_count,
            COUNT(DISTINCT DATE(records.record_date)) as active_days
        ')
            ->join('categories', 'categories.business_id = records.business_id AND categories.category_number = records.category_number')
            ->groupBy('categories.type, month')
            ->orderBy('month', 'ASC');

        // Aplicar filtros
        $this->applyFilters($builder, $businessId, $filters);

        $results = $builder->get()->getResultArray();

        // Organizar datos por mes
        $months = [];
        foreach ($results as $row) {
            $month = $row['month'];
            if (!isset($months[$month])) {
                $months[$month] = [
                    'month' => $month,
                    'incomes' => 0,
                    'expenses' => 0,
                    'records' => 0,
                    'active_days' => 0
                ];
            }

            if ($row['type'] === 'income') {
                $months[$month]['incomes'] = (float) $row['total_amount'];
            } elseif ($row['type'] === 'expense') {
                $months[$month]['expenses'] = (float) $row['total_amount'];
            }

            $months[$month]['records'] += (int) $row['record_count'];
            $months[$month]['active_days'] = max($months[$month]['active_days'], (int) $row['active_days']);
        }

        // Calcular métricas
        $monthlyData = array_values($months);
        $totalMonths = count($monthlyData);

        $metrics = [
            'monthly_data' => $monthlyData,
            'averages' => [
                'monthly_income' => $totalMonths > 0 ? array_sum(array_column($monthlyData, 'incomes')) / $totalMonths : 0,
                'monthly_expenses' => $totalMonths > 0 ? array_sum(array_column($monthlyData, 'expenses')) / $totalMonths : 0,
                'monthly_records' => $totalMonths > 0 ? array_sum(array_column($monthlyData, 'records')) / $totalMonths : 0,
                'daily_income' => 0,
                'daily_expenses' => 0
            ],
            'growth' => $this->calculateGrowthRate($monthlyData)
        ];

        // Calcular promedios diarios
        $totalDays = array_sum(array_column($monthlyData, 'active_days'));
        if ($totalDays > 0) {
            $metrics['averages']['daily_income'] = array_sum(array_column($monthlyData, 'incomes')) / $totalDays;
            $metrics['averages']['daily_expenses'] = array_sum(array_column($monthlyData, 'expenses')) / $totalDays;
        }

        return $metrics;
    }

    /**
     * Obtiene análisis por método de pago
     * 
     * @param string|null $businessId ID del negocio
     * @param array $filters Filtros de fecha
     * @return array Análisis por método de pago
     */
    public function getPaymentMethodAnalysis($businessId = null, array $filters = []): array
    {
        $builder = $this->builder();

        $builder->select('
            records.payment_method,
            categories.type,
            SUM(records.amount) as total_amount,
            COUNT(records.id) as record_count,
            AVG(records.amount) as average_amount
        ')
            ->join('categories', 'categories.category_number = records.category_number')
            ->groupBy('records.payment_method, categories.type')
            ->orderBy('total_amount', 'DESC');

        // Aplicar filtros
        $this->applyFilters($builder, $businessId, $filters);

        $results = $builder->get()->getResultArray();

        // Organizar datos
        $paymentMethods = [];
        $totalAmount = 0;

        foreach ($results as $row) {
            $method = $row['payment_method'];
            $amount = (float) $row['total_amount'];
            $totalAmount += $amount;

            if (!isset($paymentMethods[$method])) {
                $paymentMethods[$method] = [
                    'method' => $method,
                    'display_name' => $this->getPaymentMethodDisplayName($method),
                    'incomes' => 0,
                    'expenses' => 0,
                    'total_amount' => 0,
                    'record_count' => 0,
                    'average_amount' => 0
                ];
            }

            if ($row['type'] === 'income') {
                $paymentMethods[$method]['incomes'] += $amount;
            } elseif ($row['type'] === 'expense') {
                $paymentMethods[$method]['expenses'] += $amount;
            }

            $paymentMethods[$method]['total_amount'] += $amount;
            $paymentMethods[$method]['record_count'] += (int) $row['record_count'];
            $paymentMethods[$method]['average_amount'] = (float) $row['average_amount'];
        }

        // Calcular porcentajes
        foreach ($paymentMethods as &$method) {
            $method['percentage'] = $totalAmount > 0 ? ($method['total_amount'] / $totalAmount) * 100 : 0;
        }

        return [
            'period' => $this->getPeriodDescription($filters),
            'total_amount' => $totalAmount,
            'payment_methods' => array_values($paymentMethods)
        ];
    }

    // ===========================================
    // MÉTODOS AUXILIARES
    // ===========================================

    /**
     * Aplica filtros comunes a las consultas
     */
    private function applyFilters($builder, $businessId = null, array $filters = [])
    {
        // Filtro por negocio
        if ($businessId) {
            $builder->where('records.business_id', uuid_to_bytes($businessId));
        }

        // Filtros de fecha
        if (!empty($filters['start_date'])) {
            $builder->where('records.record_date >=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $builder->where('records.record_date <=', $filters['end_date']);
        }

        // Filtros de período predefinido
        if (!empty($filters['period'])) {
            $dates = $this->getPeriodDates($filters['period']);
            $builder->where('records.record_date >=', $dates['start']);
            $builder->where('records.record_date <=', $dates['end']);
        }

        // Filtro por método de pago
        if (!empty($filters['payment_method'])) {
            $builder->where('records.payment_method', $filters['payment_method']);
        }

        // Filtro por categoría
        if (!empty($filters['category_number'])) {
            $builder->where('records.category_number', $filters['category_number']);
        }
    }

    /**
     * Obtiene el formato de fecha según el tipo de agrupación
     */
    private function getDateFormat(string $groupBy): string
    {
        return match ($groupBy) {
            'day' => '%Y-%m-%d',
            'week' => '%Y-%u',
            'month' => '%Y-%m',
            'year' => '%Y',
            default => '%Y-%m-%d'
        };
    }

    /**
     * Obtiene las fechas de un período predefinido
     */
    private function getPeriodDates(string $period): array
    {
        $now = new \DateTime();

        return match ($period) {
            'today' => [
                'start' => $now->format('Y-m-d'),
                'end' => $now->format('Y-m-d')
            ],
            'yesterday' => [
                'start' => $now->modify('-1 day')->format('Y-m-d'),
                'end' => $now->format('Y-m-d')
            ],
            'this_week' => [
                'start' => $now->modify('monday this week')->format('Y-m-d'),
                'end' => $now->modify('sunday this week')->format('Y-m-d')
            ],
            'last_week' => [
                'start' => $now->modify('monday last week')->format('Y-m-d'),
                'end' => $now->modify('sunday last week')->format('Y-m-d')
            ],
            'this_month' => [
                'start' => $now->modify('first day of this month')->format('Y-m-d'),
                'end' => $now->modify('last day of this month')->format('Y-m-d')
            ],
            'last_month' => [
                'start' => $now->modify('first day of last month')->format('Y-m-d'),
                'end' => $now->modify('last day of last month')->format('Y-m-d')
            ],
            'this_year' => [
                'start' => $now->modify('first day of January')->format('Y-m-d'),
                'end' => $now->modify('last day of December')->format('Y-m-d')
            ],
            'last_year' => [
                'start' => $now->modify('first day of January last year')->format('Y-m-d'),
                'end' => $now->modify('last day of December last year')->format('Y-m-d')
            ],
            default => [
                'start' => $now->modify('-30 days')->format('Y-m-d'),
                'end' => $now->format('Y-m-d')
            ]
        };
    }

    /**
     * Obtiene la descripción del período para mostrar en reportes
     */
    private function getPeriodDescription(array $filters): string
    {
        if (!empty($filters['period'])) {
            return match ($filters['period']) {
                'today' => 'Hoy',
                'yesterday' => 'Ayer',
                'this_week' => 'Esta semana',
                'last_week' => 'Semana pasada',
                'this_month' => 'Este mes',
                'last_month' => 'Mes pasado',
                'this_year' => 'Este año',
                'last_year' => 'Año pasado',
                default => 'Período personalizado'
            };
        }

        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            return "Del {$filters['start_date']} al {$filters['end_date']}";
        }

        return 'Todos los registros';
    }

    /**
     * Obtiene el nombre de visualización del método de pago
     */
    private function getPaymentMethodDisplayName(string $method): string
    {
        return match ($method) {
            'cash' => 'Efectivo',
            'card' => 'Tarjeta de Débito/Crédito',
            'transfer' => 'Transferencia Bancaria',
            default => ucfirst($method)
        };
    }

    /**
     * Calcula la tasa de crecimiento entre períodos
     */
    private function calculateGrowthRate(array $monthlyData): array
    {
        $growth = [
            'income_growth' => 0,
            'expense_growth' => 0,
            'profit_growth' => 0
        ];

        if (count($monthlyData) >= 2) {
            $first = $monthlyData[0];
            $last = end($monthlyData);

            if ($first['incomes'] > 0) {
                $growth['income_growth'] = (($last['incomes'] - $first['incomes']) / $first['incomes']) * 100;
            }

            if ($first['expenses'] > 0) {
                $growth['expense_growth'] = (($last['expenses'] - $first['expenses']) / $first['expenses']) * 100;
            }

            $firstProfit = $first['incomes'] - $first['expenses'];
            $lastProfit = $last['incomes'] - $last['expenses'];

            if ($firstProfit > 0) {
                $growth['profit_growth'] = (($lastProfit - $firstProfit) / $firstProfit) * 100;
            }
        }

        return $growth;
    }
}
