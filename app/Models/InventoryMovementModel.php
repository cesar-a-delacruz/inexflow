<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\InventoryMovement;
use CodeIgniter\Database\Exceptions\DatabaseException;
use Ramsey\Uuid\UuidInterface;

class InventoryMovementModel extends Model
{
    protected $table = 'inventory_movements';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = InventoryMovement::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'business_id',
        'product_id',
        'movement_type',
        'quantity',
        'unit_cost',
        'reference_type',
        'reference_id',
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
        'product_id' => 'required',
        'movement_type' => 'required|in_list[in,out,adjustment]',
        'quantity' => 'required|integer|greater_than[0]',
        'unit_cost' => 'permit_empty|decimal|greater_than[0]',
        'reference_type' => 'permit_empty|in_list[sale,purchase,adjustment]',
        'reference_id' => 'permit_empty|integer',
        'created_by' => 'required'
    ];

    protected $validationMessages = [
        'business_id' => [
            'required' => 'El ID del negocio es requerido',
        ],
        'product_id' => [
            'required' => 'El ID del producto es requerido',
        ],
        'movement_type' => [
            'required' => 'El tipo de movimiento es requerido',
            'in_list' => 'El tipo de movimiento debe ser: in, out, adjustment'
        ],
        'quantity' => [
            'required' => 'La cantidad es requerida',
            'integer' => 'La cantidad debe ser un número entero',
            'greater_than' => 'La cantidad debe ser mayor a 0'
        ],
        'unit_cost' => [
            'decimal' => 'El costo unitario debe ser un número decimal',
            'greater_than' => 'El costo unitario debe ser mayor a 0'
        ],
        'reference_type' => [
            'in_list' => 'El tipo de referencia debe ser: sale, purchase, adjustment'
        ],
        'reference_id' => [
            'integer' => 'El ID de referencia debe ser un número entero'
        ],
        'created_by' => [
            'required' => 'El usuario creador es requerido',
        ]
    ];

    protected $skipValidation = false;

    /**
     * Crear un nuevo movimiento de inventario
     */
    public function createInventoryMovement(InventoryMovement $inventoryMovement, $returnID = true): bool|int
    {
        try {
            $result = $this->insert($inventoryMovement);

            if ($result === false) {
                throw new DatabaseException('Error al insertar el movimiento de inventario: ' . implode(', ', $this->errors()));
            }

            if ($returnID) return $this->getInsertID();

            return $result;
        } catch (\Exception $e) {
            log_message('error', 'Error creando movimiento de inventario: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Obtener movimiento de inventario por ID
     */
    public function getInventoryMovement(int $id): ?InventoryMovement
    {
        return $this->find($id);
    }

    /**
     * Obtener movimientos de inventario por negocio
     */
    public function getMovementsByBusiness(UuidInterface|string $businessId): array
    {
        return $this->where('business_id', uuid_to_bytes($businessId))->findAll();
    }

    /**
     * Obtener movimientos de inventario por producto
     */
    public function getMovementsByProduct(UuidInterface|string $productId): array
    {
        return $this->where('product_id', uuid_to_bytes($productId))->findAll();
    }

    /**
     * Obtener movimientos por tipo
     */
    public function getMovementsByType(UuidInterface|string $businessId, string $movementType): array
    {
        return $this->where('business_id', uuid_to_bytes($businessId))
            ->where('movement_type', $movementType)
            ->findAll();
    }

    /**
     * Obtener movimientos por rango de fechas
     */
    public function getMovementsByDateRange(UuidInterface|string $businessId, string $startDate, string $endDate): array
    {
        return $this->where('business_id', uuid_to_bytes($businessId))
            ->where('created_at >=', $startDate)
            ->where('created_at <=', $endDate)
            ->findAll();
    }

    /**
     * Obtener stock actual de un producto
     */
    public function getCurrentStock(UuidInterface|string $businessId, UuidInterface|string $productId): int
    {
        $inMovements = $this->selectSum('quantity')
            ->where('business_id', uuid_to_bytes($businessId))
            ->where('product_id', uuid_to_bytes($productId))
            ->where('movement_type', 'in')
            ->get()
            ->getRow();

        $outMovements = $this->selectSum('quantity')
            ->where('business_id', uuid_to_bytes($businessId))
            ->where('product_id', uuid_to_bytes($productId))
            ->whereIn('movement_type', ['out', 'adjustment'])
            ->get()
            ->getRow();

        $inTotal = $inMovements->quantity ?? 0;
        $outTotal = $outMovements->quantity ?? 0;

        return $inTotal - $outTotal;
    }

    /**
     * Obtener movimientos con paginación
     */
    public function getMovementsPaginated(UuidInterface|string $businessId, int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;

        $movements = $this->where('business_id', uuid_to_bytes($businessId))
            ->orderBy('created_at', 'DESC')
            ->findAll($perPage, $offset);

        $total = $this->where('business_id', uuid_to_bytes($businessId))
            ->countAllResults();

        return [
            'data' => $movements,
            'total' => $total,
            'page' => $page,
            'per_page' => $perPage,
            'total_pages' => ceil($total / $perPage)
        ];
    }

    /**
     * Obtener resumen de movimientos por tipo
     */
    public function getMovementsSummary(UuidInterface|string $businessId, string $startDate = null, string $endDate = null): array
    {
        $query = $this->select('movement_type, COUNT(*) as count, SUM(quantity) as total_quantity')
            ->where('business_id', uuid_to_bytes($businessId));

        if ($startDate) {
            $query->where('created_at >=', $startDate);
        }

        if ($endDate) {
            $query->where('created_at <=', $endDate);
        }

        $results = $query->groupBy('movement_type')->findAll();

        $summary = [];
        foreach ($results as $result) {
            $summary[$result['movement_type']] = [
                'count' => $result['count'],
                'total_quantity' => $result['total_quantity']
            ];
        }

        return $summary;
    }

    /**
     * Obtener productos con bajo stock
     */
    public function getLowStockProducts(UuidInterface|string $businessId, int $threshold = 10): array
    {
        $sql = "
            SELECT 
                p.id as product_id,
                p.name as product_name,
                COALESCE(SUM(CASE WHEN im.movement_type = 'in' THEN im.quantity ELSE 0 END), 0) -
                COALESCE(SUM(CASE WHEN im.movement_type IN ('out', 'adjustment') THEN im.quantity ELSE 0 END), 0) as current_stock
            FROM products p
            LEFT JOIN inventory_movements im ON p.id = im.product_id AND im.business_id = ?
            WHERE p.business_id = ?
            GROUP BY p.id, p.name
            HAVING current_stock <= ?
            ORDER BY current_stock ASC
        ";

        $businessBytes = uuid_to_bytes($businessId);

        return $this->query($sql, [$businessBytes, $businessBytes, $threshold])->getResultArray();
    }
}
