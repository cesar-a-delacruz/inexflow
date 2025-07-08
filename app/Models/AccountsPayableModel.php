<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\AccountsPayable;
use CodeIgniter\Database\Exceptions\DatabaseException;
use Ramsey\Uuid\UuidInterface;

class AccountsPayableModel extends Model
{
    protected $table = 'accounts_payable';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false;
    protected $returnType = AccountsPayable::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id',
        'business_id',
        'contact_id',
        'transaction_id',
        'invoice_number',
        'description',
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
        'contact_id' => 'required',
        'transaction_id' => 'permit_empty|integer',
        'invoice_number' => 'permit_empty|max_length[100]',
        'description' => 'required|max_length[255]',
        'original_amount' => 'required|decimal|greater_than[0]',
        'paid_amount' => 'permit_empty|decimal|greater_than_equal_to[0]',
        'balance_due' => 'required|decimal|greater_than_equal_to[0]',
        'due_date' => 'required|valid_date',
        'status' => 'required|in_list[pending,overdue,paid]'
    ];

    protected $validationMessages = [
        'id' => [
            'required' => 'El ID es requerido',
        ],
        'business_id' => [
            'required' => 'El ID del negocio es requerido',
        ],
        'contact_id' => [
            'required' => 'El ID del proveedor es requerido',
        ],
        'transaction_id' => [
            'integer' => 'El ID de transacción debe ser un número entero'
        ],
        'invoice_number' => [
            'max_length' => 'El número de factura no puede exceder 100 caracteres'
        ],
        'description' => [
            'required' => 'La descripción es requerida',
            'max_length' => 'La descripción no puede exceder 255 caracteres'
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
            'required' => 'El estado es requerido',
            'in_list' => 'El estado debe ser: pending, overdue, paid'
        ]
    ];

    protected $skipValidation = false;

    /**
     * Crear una nueva cuenta por pagar
     */
    public function createAccountsPayable(AccountsPayable $accountsPayable, $returnID = true): bool|string
    {
        try {
            // Generar UUID si no existe
            if (!$accountsPayable->id) {
                $accountsPayable->id = generate_uuid();
            }

            $result = $this->insert($accountsPayable);

            if ($result === false) {
                throw new DatabaseException('Error al insertar la cuenta por pagar: ' . implode(', ', $this->errors()));
            }

            if ($returnID) return $accountsPayable->id;

            return $result;
        } catch (\Exception $e) {
            log_message('error', 'Error creando cuenta por pagar: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Obtener cuenta por pagar por ID
     */
    public function getAccountsPayable(UuidInterface|string $id): ?AccountsPayable
    {
        return $this->where('id', uuid_to_bytes($id))->first();
    }

    /**
     * Obtener cuentas por pagar por negocio
     */
    public function getAccountsPayableByBusiness(UuidInterface|string $businessId): array
    {
        return $this->where('business_id', uuid_to_bytes($businessId))->findAll();
    }

    /**
     * Obtener cuentas por pagar por proveedor
     */
    public function getAccountsPayableBySupplier(UuidInterface|string $businessId, UuidInterface|string $supplierId): array
    {
        return $this->where('business_id', uuid_to_bytes($businessId))
            ->where('contact_id', uuid_to_bytes($supplierId))
            ->findAll();
    }

    /**
     * Obtener cuentas por pagar por estado
     */
    public function getAccountsPayableByStatus(UuidInterface|string $businessId, string $status): array
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
            ->where('due_date <', date('Y-m-d'))
            ->where('status !=', 'paid')
            ->findAll();
    }

    /**
     * Obtener cuentas que vencen pronto
     */
    public function getAccountsDueSoon(UuidInterface|string $businessId, int $days = 7): array
    {
        $dueDate = date('Y-m-d', strtotime("+{$days} days"));

        return $this->where('business_id', uuid_to_bytes($businessId))
            ->where('due_date <=', $dueDate)
            ->where('due_date >=', date('Y-m-d'))
            ->where('status !=', 'paid')
            ->findAll();
    }

    /**
     * Registrar un pago
     */
    public function recordPayment(UuidInterface|string $id, float $paymentAmount): bool
    {
        try {
            $account = $this->getAccountsPayable($id);

            if (!$account) {
                throw new \Exception('Cuenta por pagar no encontrada');
            }

            $newPaidAmount = $account->paid_amount + $paymentAmount;
            $newBalance = $account->original_amount - $newPaidAmount;

            $updateData = [
                'paid_amount' => $newPaidAmount,
                'balance_due' => $newBalance,
                'status' => $newBalance <= 0 ? 'paid' : 'pending'
            ];

            return $this->update($id, $updateData);
        } catch (\Exception $e) {
            log_message('error', 'Error registrando pago: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Obtener resumen de cuentas por pagar
     */
    public function getPayablesSummary(UuidInterface|string $businessId): array
    {
        $query = $this->select('
            status,
            COUNT(*) as count,
            SUM(original_amount) as total_original,
            SUM(paid_amount) as total_paid,
            SUM(balance_due) as total_balance
        ')
            ->where('business_id', uuid_to_bytes($businessId))
            ->groupBy('status')
            ->findAll();

        $summary = [
            'pending' => ['count' => 0, 'total_original' => 0, 'total_paid' => 0, 'total_balance' => 0],
            'overdue' => ['count' => 0, 'total_original' => 0, 'total_paid' => 0, 'total_balance' => 0],
            'paid' => ['count' => 0, 'total_original' => 0, 'total_paid' => 0, 'total_balance' => 0]
        ];

        foreach ($query as $row) {
            $summary[$row['status']] = [
                'count' => $row['count'],
                'total_original' => $row['total_original'],
                'total_paid' => $row['total_paid'],
                'total_balance' => $row['total_balance']
            ];
        }

        return $summary;
    }

    /**
     * Obtener cuentas por pagar con paginación
     */
    public function getAccountsPayablePaginated(UuidInterface|string $businessId, int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;

        $accounts = $this->where('business_id', uuid_to_bytes($businessId))
            ->orderBy('due_date', 'ASC')
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
    public function updateOverdueStatus(UuidInterface|string $businessId): int
    {
        return $this->where('business_id', uuid_to_bytes($businessId))
            ->where('due_date <', date('Y-m-d'))
            ->where('status !=', 'paid')
            ->set('status', 'overdue')
            ->update();
    }

    /**
     * Obtener total de deuda por proveedor
     */
    public function getTotalDebtBySupplier(UuidInterface|string $businessId): array
    {
        $sql = "
            SELECT 
                s.id as supplier_id,
                s.name as supplier_name,
                COUNT(ap.id) as total_accounts,
                SUM(ap.balance_due) as total_debt,
                AVG(ap.balance_due) as avg_debt
            FROM contacts s
            LEFT JOIN accounts_payable ap ON s.id = ap.contact_id 
                AND ap.business_id = ? 
                AND ap.status != 'paid'
            WHERE s.business_id = ?
            GROUP BY s.id, s.name
            HAVING total_debt > 0
            ORDER BY total_debt DESC
        ";

        $businessBytes = uuid_to_bytes($businessId);

        return $this->query($sql, [$businessBytes, $businessBytes])->getResultArray();
    }
}
