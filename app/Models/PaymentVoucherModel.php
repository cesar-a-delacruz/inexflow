<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\PaymentVoucher;
use CodeIgniter\Database\Exceptions\DatabaseException;
use Ramsey\Uuid\UuidInterface;

class PaymentVoucherModel extends Model
{
    protected $table = 'payment_vouchers';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false;
    protected $returnType = PaymentVoucher::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id',
        'business_id',
        'contact_id',
        'account_payable_id',
        'amount',
        'payment_method',
        'payment_date',
        'reference',
        'notes',
        'created_by'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = null;
    protected $deletedField = null;

    protected $validationRules = [
        'business_id' => 'required',
        'contact_id' => 'required',
        'amount' => 'required|decimal|greater_than[0]',
        'payment_method' => 'required|in_list[cash,card,transfer,check]',
        'payment_date' => 'required|valid_date',
        'created_by' => 'required'
    ];

    protected $validationMessages = [
        'business_id' => [
            'required' => 'El ID del negocio es requerido',
        ],
        'contact_id' => [
            'required' => 'El ID del proveedor es requerido',
        ],
        'amount' => [
            'required' => 'El monto es requerido',
            'decimal' => 'El monto debe ser un número decimal',
            'greater_than' => 'El monto debe ser mayor a 0'
        ],
        'payment_method' => [
            'required' => 'El método de pago es requerido',
            'in_list' => 'El método de pago debe ser: cash, card, transfer, check'
        ],
        'payment_date' => [
            'required' => 'La fecha de pago es requerida',
            'valid_date' => 'La fecha de pago debe ser válida'
        ],
        'created_by' => [
            'required' => 'El usuario creador es requerido',
        ]
    ];

    protected $skipValidation = false;

    /**
     * Crear un nuevo comprobante de pago
     */
    public function createPaymentVoucher(PaymentVoucher $paymentVoucher, $returnID = true): bool|int|UuidInterface
    {
        try {
            if ($paymentVoucher->id === null) {
                $paymentVoucher->id = generate_uuid();
            }

            $result = $this->insert($paymentVoucher);

            if ($result === false) {
                throw new DatabaseException('Error al insertar el comprobante de pago: ' . implode(', ', $this->errors()));
            }

            if ($returnID) return $paymentVoucher->id;

            return $result;
        } catch (\Exception $e) {
            log_message('error', 'Error creando comprobante de pago: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Obtener comprobante de pago por ID
     */
    public function getPaymentVoucher(UuidInterface|string $id): ?PaymentVoucher
    {
        return $this->find(uuid_to_bytes($id));
    }

    /**
     * Obtener comprobantes de pago por negocio
     */
    public function getVouchersByBusiness(UuidInterface|string $businessId): array
    {
        return $this->where('business_id', uuid_to_bytes($businessId))->findAll();
    }

    /**
     * Obtener comprobantes de pago por proveedor
     */
    public function getVouchersBySupplier(UuidInterface|string $supplierId): array
    {
        return $this->where('contact_id', uuid_to_bytes($supplierId))->findAll();
    }

    /**
     * Obtener comprobantes de pago por rango de fechas
     */
    public function getVouchersByDateRange(UuidInterface|string $businessId, string $startDate, string $endDate): array
    {
        return $this->where('business_id', uuid_to_bytes($businessId))
            ->where('payment_date >=', $startDate)
            ->where('payment_date <=', $endDate)
            ->findAll();
    }

    /**
     * Obtener comprobantes de pago por método de pago
     */
    public function getVouchersByPaymentMethod(UuidInterface|string $businessId, string $paymentMethod): array
    {
        return $this->where('business_id', uuid_to_bytes($businessId))
            ->where('payment_method', $paymentMethod)
            ->findAll();
    }

    /**
     * Obtener total de pagos por negocio en un rango de fechas
     */
    public function getTotalPaymentsByBusiness(UuidInterface|string $businessId, string $startDate, string $endDate): float
    {
        $result = $this->selectSum('amount')
            ->where('business_id', uuid_to_bytes($businessId))
            ->where('payment_date >=', $startDate)
            ->where('payment_date <=', $endDate)
            ->get()
            ->getRow();

        return $result->amount ?? 0.00;
    }

    /**
     * Obtener comprobantes con paginación
     */
    public function getVouchersPaginated(UuidInterface|string $businessId, int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;

        $vouchers = $this->where('business_id', uuid_to_bytes($businessId))
            ->findAll($perPage, $offset);

        $total = $this->where('business_id', uuid_to_bytes($businessId))
            ->countAllResults();

        return [
            'data' => $vouchers,
            'total' => $total,
            'page' => $page,
            'per_page' => $perPage,
            'total_pages' => ceil($total / $perPage)
        ];
    }

    /**
     * Obtener estadísticas de pagos por método
     */
    public function getPaymentMethodStats(UuidInterface|string $businessId): array
    {
        $results = $this->select('payment_method, COUNT(*) as count, SUM(amount) as total_amount')
            ->where('business_id', uuid_to_bytes($businessId))
            ->groupBy('payment_method')
            ->findAll();

        $stats = [];
        foreach ($results as $result) {
            $stats[$result['payment_method']] = [
                'count' => $result['count'],
                'total_amount' => $result['total_amount']
            ];
        }

        return $stats;
    }
}
