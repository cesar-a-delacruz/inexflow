<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\AccountsReceivable;
use CodeIgniter\Database\Exceptions\DatabaseException;
use Ramsey\Uuid\UuidInterface;

class AccountsReceivableModel extends Model
{
    protected $table = 'accounts_receivable';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false;
    protected $returnType = AccountsReceivable::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id',
        'business_id',
        'customer_id',
        'invoice_id',
        'original_amount',
        'paid_amount',
        'balance_due',
        'due_date',
        'status'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = null;

    protected $validationRules = [
        'id' => 'required',
        'business_id' => 'required',
        'customer_id' => 'required',
        'invoice_id' => 'required',
        'original_amount' => 'required|decimal|greater_than[0]',
        'paid_amount' => 'permit_empty|decimal|greater_than_equal_to[0]',
        'balance_due' => 'required|decimal|greater_than_equal_to[0]',
        'due_date' => 'required|valid_date',
        'status' => 'permit_empty|in_list[current,overdue,paid]'
    ];

    protected $validationMessages = [
        'id' => [
            'required' => 'El ID es requerido',
        ],
        'business_id' => [
            'required' => 'El ID del negocio es requerido',
        ],
        'customer_id' => [
            'required' => 'El ID del cliente es requerido',
        ],
        'invoice_id' => [
            'required' => 'El ID de la factura es requerido',
        ],
        'original_amount' => [
            'required' => 'El monto original es requerido',
            'decimal' => 'El monto original debe ser un número decimal',
            'greater_than' => 'El monto original debe ser mayor a 0'
        ],
        'paid_amount' => [
            'decimal' => 'El monto pagado debe ser un número decimal',
            'greater_than_equal_to' => 'El monto pagado debe ser mayor o igual a 0'
        ],
        'balance_due' => [
            'required' => 'El saldo pendiente es requerido',
            'decimal' => 'El saldo pendiente debe ser un número decimal',
            'greater_than_equal_to' => 'El saldo pendiente debe ser mayor o igual a 0'
        ],
        'due_date' => [
            'required' => 'La fecha de vencimiento es requerida',
            'valid_date' => 'La fecha de vencimiento debe ser una fecha válida'
        ],
        'status' => [
            'in_list' => 'El estado debe ser: current, overdue, paid'
        ]
    ];

    protected $skipValidation = false;

    protected $beforeInsert = ['generateUuid'];
    protected $beforeUpdate = ['updateBalanceDue'];

    /**
     * Crear una nueva cuenta por cobrar
     */
    public function createAccountReceivable(AccountsReceivable $accountReceivable): bool|string
    {

        // Generar UUID si no existe
        if (!$accountReceivable->id) {
            $accountReceivable->id = generate_uuid();
        }

        try {
            $result = $this->insert($accountReceivable);

            if ($result === false) {
                throw new DatabaseException('Error al insertar la cuenta por cobrar: ' . implode(', ', $this->errors()));
            }

            return $accountReceivable->id;
        } catch (\Exception $e) {
            log_message('error', 'Error creando cuenta por cobrar: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Obtener cuenta por cobrar por ID
     */
    public function getAccountReceivable(UuidInterface|string $id): ?AccountsReceivable
    {
        return $this->find(uuid_to_bytes($id));
    }

    /**
     * Obtener cuentas por cobrar por negocio
     */
    public function getAccountsByBusiness(UuidInterface|string $businessId): array
    {
        return $this->where('business_id', uuid_to_bytes($businessId))->findAll();
    }

    /**
     * Obtener cuentas por cobrar por cliente
     */
    public function getAccountsByCustomer(UuidInterface|string $businessId, UuidInterface|string $customerId): array
    {
        return $this->where('business_id', uuid_to_bytes($businessId))
            ->where('customer_id', uuid_to_bytes($customerId))
            ->findAll();
    }

    /**
     * Obtener cuentas por cobrar por estado
     */
    public function getAccountsByStatus(UuidInterface|string $businessId, string $status): array
    {
        return $this->where('business_id', uuid_to_bytes($businessId))
            ->where('status', $status)
            ->findAll();
    }

    /**
     * Obtener cuentas vencidas
     */
    public function getOverdueAccounts(UuidInterface|string $businessId): array
    {
        return $this->where('business_id', uuid_to_bytes($businessId))
            ->where('status', 'overdue')
            ->orWhere('due_date <', date('Y-m-d'))
            ->findAll();
    }

    /**
     * Obtener cuentas por rango de fechas de vencimiento
     */
    public function getAccountsByDueDateRange(UuidInterface|string $businessId, string $startDate, string $endDate): array
    {
        return $this->where('business_id', uuid_to_bytes($businessId))
            ->where('due_date >=', $startDate)
            ->where('due_date <=', $endDate)
            ->findAll();
    }

    /**
     * Registrar un pago
     */
    public function recordPayment(UuidInterface|string $accountId, float $paymentAmount): bool
    {
        try {
            $account = $this->find(uuid_to_bytes($accountId));

            if (!$account) {
                throw new DatabaseException('Cuenta por cobrar no encontrada');
            }

            $newPaidAmount = $account->paid_amount + $paymentAmount;
            $newBalance = $account->original_amount - $newPaidAmount;

            $updateData = [
                'paid_amount' => $newPaidAmount,
                'balance_due' => $newBalance,
                'status' => $newBalance <= 0 ? 'paid' : ($account->due_date < date('Y-m-d') ? 'overdue' : 'current')
            ];

            return $this->update(uuid_to_bytes($accountId), $updateData);
        } catch (\Exception $e) {
            log_message('error', 'Error registrando pago: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Obtener resumen de cuentas por cobrar
     */
    public function getAccountsReceivableSummary(UuidInterface|string $businessId): array
    {
        $summary = $this->select('
                status,
                COUNT(*) as count,
                SUM(original_amount) as total_original,
                SUM(paid_amount) as total_paid,
                SUM(balance_due) as total_balance
            ')
            ->where('business_id', uuid_to_bytes($businessId))
            ->groupBy('status')
            ->findAll();

        $result = [];
        foreach ($summary as $item) {
            $result[$item['status']] = [
                'count' => $item['count'],
                'total_original' => $item['total_original'],
                'total_paid' => $item['total_paid'],
                'total_balance' => $item['total_balance']
            ];
        }

        return $result;
    }

    /**
     * Obtener cuentas con paginación
     */
    public function getAccountsPaginated(UuidInterface|string $businessId, int $page = 1, int $perPage = 10, array $filters = []): array
    {
        $offset = ($page - 1) * $perPage;

        $query = $this->where('business_id', uuid_to_bytes($businessId));

        // Aplicar filtros
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['customer_id'])) {
            $query->where('customer_id', uuid_to_bytes($filters['customer_id']));
        }

        if (!empty($filters['due_date_from'])) {
            $query->where('due_date >=', $filters['due_date_from']);
        }

        if (!empty($filters['due_date_to'])) {
            $query->where('due_date <=', $filters['due_date_to']);
        }

        $accounts = $query->orderBy('due_date', 'ASC')
            ->findAll($perPage, $offset);

        $total = $this->where('business_id', uuid_to_bytes($businessId))
            ->countAllResults();

        return [
            'data' => $accounts,
            'total' => $total,
            'page' => $page,
            'per_page' => $perPage,
            'total_pages' => ceil($total / $perPage)
        ];
    }

    /**
     * Actualizar estados de cuentas vencidas
     */
    public function updateOverdueStatuses(UuidInterface|string $businessId): int
    {
        return $this->where('business_id', uuid_to_bytes($businessId))
            ->where('due_date <', date('Y-m-d'))
            ->where('status !=', 'paid')
            ->set('status', 'overdue')
            ->update();
    }

    /**
     * Obtener total de cuentas por cobrar
     */
    public function getTotalReceivables(UuidInterface|string $businessId): float
    {
        $result = $this->selectSum('balance_due')
            ->where('business_id', uuid_to_bytes($businessId))
            ->where('status !=', 'paid')
            ->get()
            ->getRow();

        return $result->balance_due ?? 0;
    }
}
