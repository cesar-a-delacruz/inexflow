<?php

namespace App\Models;

use App\Entities\Record;
use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class ReportModel extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'id',
        'business_id',
        'contact_id',
        'number',
        'total',
        'due_date',
        'payment_status',
        'payment_method',
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // ===========================================
    // MÉTODOS PARA GRÁFICAS DE TRANSACCIONES
    // ===========================================

    /**
     * Obtiene datos para gráfica de ventas por período (líneas o barras)
     */
    public function getSalesChart(string $businessId, array $filters = [], string $groupBy = 'day'): array
    {
        $builder = $this->db->table('transactions');

        $dateFormat = $this->getDateFormat($groupBy);

        $builder->select("DATE_FORMAT(created_at, '$dateFormat') as period")
            ->selectSum('total', 'total_sales')
            ->selectCount('id', 'transactions_count')
            ->where('business_id', uuid_to_bytes($businessId))
            ->where('deleted_at IS NULL');

        $this->applyDateFilters($builder, $filters);

        $builder->groupBy('period')
            ->orderBy('period', 'ASC');

        $results = $builder->get()->getResultArray();

        return [
            'data' => $results,
            'period_description' => $this->getPeriodDescription($filters),
            'group_by' => $groupBy
        ];
    }

    /**
     * Obtiene datos para gráfica de estado de pagos (dona o barras)
     */
    public function getPaymentStatusChart(string $businessId, array $filters = []): array
    {
        $builder = $this->db->table('transactions');

        $builder->select('payment_status as status')
            ->selectCount('id', 'count')
            ->selectSum('total', 'total_amount')
            ->where('business_id', uuid_to_bytes($businessId))
            ->where('deleted_at IS NULL');

        $this->applyDateFilters($builder, $filters);

        $builder->groupBy('payment_status')
            ->orderBy('count', 'DESC');

        $results = $builder->get()->getResultArray();

        // Traducir estados al español
        foreach ($results as &$result) {
            $result['status_label'] = $this->translatePaymentStatus($result['status']);
        }

        return [
            'data' => $results,
            'period_description' => $this->getPeriodDescription($filters)
        ];
    }

    /**
     * Obtiene datos para gráfica de métodos de pago (dona)
     */
    public function getPaymentMethodChart(string $businessId, array $filters = []): array
    {
        $builder = $this->db->table('transactions');

        $builder->select('payment_method as method')
            ->selectCount('id', 'count')
            ->selectSum('total', 'total_amount')
            ->where('business_id', uuid_to_bytes($businessId))
            ->where('payment_method IS NOT NULL')
            ->where('deleted_at IS NULL');

        $this->applyDateFilters($builder, $filters);

        $builder->groupBy('payment_method')
            ->orderBy('count', 'DESC');

        $results = $builder->get()->getResultArray();

        // Traducir métodos de pago al español
        foreach ($results as &$result) {
            $result['method_label'] = $this->translatePaymentMethod($result['method']);
        }

        return [
            'data' => $results,
            'period_description' => $this->getPeriodDescription($filters)
        ];
    }

    /**
     * Obtiene datos para gráfica de productos/servicios más vendidos
     */
    public function getTopItemsChart(string $businessId, array $filters = [], int $limit = 10): array
    {
        $builder = $this->db->table('records r');

        $builder->select('i.name as item_name, i.type as item_type')
            ->selectSum('r.amount', 'quantity_sold')
            ->selectSum('r.subtotal', 'total_revenue')
            ->join('items i', 'r.item_id = i.id', 'left')
            ->join('transactions t', 'r.transaction_id = t.id', 'left')
            ->where('r.business_id', uuid_to_bytes($businessId))
            ->where('r.deleted_at IS NULL')
            ->where('t.deleted_at IS NULL');

        $this->applyDateFilters($builder, $filters, 't.created_at');

        $builder->groupBy('r.item_id, i.name, i.type')
            ->orderBy('quantity_sold', 'DESC')
            ->limit($limit);

        $results = $builder->get()->getResultArray();

        return [
            'data' => $results,
            'period_description' => $this->getPeriodDescription($filters),
            'limit' => $limit
        ];
    }

    /**
     * Obtiene datos para gráfica de ingresos vs gastos por categoría
     */
    public function getIncomeVsExpenseChart(string $businessId, array $filters = []): array
    {
        $builder = $this->db->table('records r');

        $builder->select('c.name as category_name, c.type as category_type')
            ->selectSum('r.subtotal', 'total_amount')
            ->join('items i', 'r.item_id = i.id', 'left')
            ->join('categories c', 'i.category_id = c.id', 'left')
            ->join('transactions t', 'r.transaction_id = t.id', 'left')
            ->where('r.business_id', uuid_to_bytes($businessId))
            ->where('c.id IS NOT NULL')
            ->where('r.deleted_at IS NULL')
            ->where('t.deleted_at IS NULL');

        $this->applyDateFilters($builder, $filters, 't.created_at');

        $builder->groupBy('c.id, c.name, c.type')
            ->orderBy('total_amount', 'DESC');

        $results = $builder->get()->getResultArray();

        // Separar ingresos y gastos
        $income = [];
        $expenses = [];

        foreach ($results as $result) {
            if ($result['category_type'] === 'income') {
                $income[] = $result;
            } else {
                $expenses[] = $result;
            }
        }

        return [
            'income' => $income,
            'expenses' => $expenses,
            'period_description' => $this->getPeriodDescription($filters)
        ];
    }

    /**
     * Obtiene datos para gráfica de clientes más frecuentes
     */
    public function getTopCustomersChart(string $businessId, array $filters = [], int $limit = 10): array
    {
        $builder = $this->db->table('transactions t');

        $builder->select('c.name as customer_name, c.email, c.phone')
            ->selectCount('t.id', 'transaction_count')
            ->selectSum('t.total', 'total_spent')
            ->join('contacts c', 't.contact_id = c.id', 'left')
            ->where('t.business_id', uuid_to_bytes($businessId))
            ->where('c.type', 'customer')
            ->where('t.contact_id IS NOT NULL')
            ->where('t.deleted_at IS NULL')
            ->where('c.deleted_at IS NULL');

        $this->applyDateFilters($builder, $filters, 't.created_at');

        $builder->groupBy('t.contact_id, c.name, c.email, c.phone')
            ->orderBy('total_spent', 'DESC')
            ->limit($limit);

        $results = $builder->get()->getResultArray();

        return [
            'data' => $results,
            'period_description' => $this->getPeriodDescription($filters),
            'limit' => $limit
        ];
    }

    /**
     * Obtiene datos para gráfica de tendencia de ventas (comparación de períodos)
     */
    public function getSalesTrendChart(string $businessId, string $currentPeriod = 'this_month', string $previousPeriod = 'last_month'): array
    {
        $currentData = $this->getSalesByPeriod($businessId, $currentPeriod);
        $previousData = $this->getSalesByPeriod($businessId, $previousPeriod);

        return [
            'current' => [
                'data' => $currentData,
                'period' => $this->getPeriodDescription(['period' => $currentPeriod])
            ],
            'previous' => [
                'data' => $previousData,
                'period' => $this->getPeriodDescription(['period' => $previousPeriod])
            ],
            'comparison' => $this->calculateGrowthRate($currentData['total'], $previousData['total'])
        ];
    }

    /**
     * Obtiene resumen de métricas para dashboard
     */
    public function getDashboardMetrics(string $businessId, array $filters = []): array
    {
        $builder = $this->db->table('transactions');

        $builder->select('
                COUNT(id) as total_transactions,
                SUM(CASE WHEN total > 0 THEN total ELSE 0 END) as total_sales,
                AVG(CASE WHEN total > 0 THEN total ELSE NULL END) as average_sale,
                SUM(CASE WHEN payment_status = "paid" THEN total ELSE 0 END) as paid_amount,
                SUM(CASE WHEN payment_status = "pending" THEN total ELSE 0 END) as pending_amount,
                SUM(CASE WHEN payment_status = "overdue" THEN total ELSE 0 END) as overdue_amount
            ')
            ->where('business_id', uuid_to_bytes($businessId))
            ->where('deleted_at IS NULL');

        $this->applyDateFilters($builder, $filters);

        $result = $builder->get()->getRowArray();

        // Calcular métricas adicionales
        $result['collection_rate'] = $result['total_sales'] > 0
            ? ($result['paid_amount'] / $result['total_sales']) * 100
            : 0;

        $result['pending_rate'] = $result['total_sales'] > 0
            ? ($result['pending_amount'] / $result['total_sales']) * 100
            : 0;

        return [
            'metrics' => $result,
            'period_description' => $this->getPeriodDescription($filters)
        ];
    }

    // ===========================================
    // MÉTODOS AUXILIARES PARA GRÁFICAS
    // ===========================================

    /**
     * Obtiene ventas por período específico
     */
    private function getSalesByPeriod(string $businessId, string $period): array
    {
        $dates = $this->getPeriodDates($period);

        $builder = $this->db->table('transactions');
        $builder->select('
                COUNT(id) as transactions,
                SUM(total) as total,
                AVG(total) as average
            ')
            ->where('business_id', uuid_to_bytes($businessId))
            ->where('created_at >=', $dates['start'] . ' 00:00:00')
            ->where('created_at <=', $dates['end'] . ' 23:59:59')
            ->where('deleted_at IS NULL');

        return $builder->get()->getRowArray();
    }

    /**
     * Calcula la tasa de crecimiento entre dos períodos
     */
    private function calculateGrowthRate(?float $current, ?float $previous): array
    {
        if (!$previous || !$current) {
            return [
                'rate' => 0,
                'direction' => 'neutral',
                'formatted' => '0%'
            ];
        }

        $rate = (($current - $previous) / $previous) * 100;
        $direction = $rate > 0 ? 'up' : ($rate < 0 ? 'down' : 'neutral');

        return [
            'rate' => round($rate, 2),
            'direction' => $direction,
            'formatted' => round($rate, 2) . '%'
        ];
    }

    /**
     * Traduce estados de pago al español
     */
    private function translatePaymentStatus(string $status): string
    {
        return match ($status) {
            'paid' => 'Pagado',
            'pending' => 'Pendiente',
            'overdue' => 'Vencido',
            'cancelled' => 'Cancelado',
            default => ucfirst($status)
        };
    }

    /**
     * Traduce métodos de pago al español
     */
    private function translatePaymentMethod(string $method): string
    {
        return match ($method) {
            'cash' => 'Efectivo',
            'card' => 'Tarjeta',
            'transfer' => 'Transferencia',
            default => ucfirst($method)
        };
    }

    // ===========================================
    // MÉTODOS AUXILIARES ORIGINALES
    // ===========================================

    /**
     * Aplica filtros de fecha a las consultas
     */
    private function applyDateFilters($builder, array $filters, string $dateColumn = 'created_at')
    {
        if (!empty($filters['start_date'])) {
            $builder->where("$dateColumn >=", $filters['start_date'] . ' 00:00:00');
        }

        if (!empty($filters['end_date'])) {
            $builder->where("$dateColumn <=", $filters['end_date'] . ' 23:59:59');
        }

        if (!empty($filters['period'])) {
            $dates = $this->getPeriodDates($filters['period']);
            $builder->where("$dateColumn >=", $dates['start'] . ' 00:00:00');
            $builder->where("$dateColumn <=", $dates['end'] . ' 23:59:59');
        }
    }

    /**
     * Obtiene el formato de fecha según el tipo de agrupación
     */
    static public function getDateFormat(string $groupBy): string
    {
        return match ($groupBy) {
            'day' => '%Y-%m-%d',
            'week' => '%Y-%u',
            'month' => '%Y-%m',
            'year' => '%Y',
            null => '%Y-%m-%d',
            default => '%Y-%m-%d'
        };
    }

    static public $dateValues = [
        'day' => 'Dia',
        'week' => 'Semana',
        'month' => 'Mes',
        'year' => 'Año',
    ];

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
        if (!empty($filters['start_date'])) {
            $start = Time::parse($filters['start_date'], 'America/Panama', 'es_ES')->toLocalizedString('d MMMM yyyy');
            if (!empty($filters['end_date'])) {
                $end = Time::parse($filters['end_date'], 'America/Panama', 'es_ES')->toLocalizedString('d MMMM yyyy');

                return "Del {$start} al {$end}";
            }
            return "A partir de {$filters['start_date']}";
        } else if (!empty($filters['end_date'])) {
            $end = Time::parse($filters['end_date'], 'America/Panama', 'es_ES')->toLocalizedString('d MMMM yyyy');
            return "Hasta {$end}";
        }

        return 'Todos los registros';
    }
}
