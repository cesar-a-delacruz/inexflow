<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Business;
use CodeIgniter\Database\Exceptions\DatabaseException;
use Ramsey\Uuid\UuidInterface;

class BusinessModel extends Model
{
    protected $table = 'businesses';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false;
    protected $returnType = Business::class;
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'id',
        'name',
        'phone',
        'owner_id',
        'status',
        'registered_by'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [
        'name' => 'required|max_length[255]',
        'status' => 'required|in_list[active,inactive]',
        'registered_by' => 'required'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'El nombre del negocio es requerido',
            'max_length' => 'El nombre del negocio no puede exceder 255 caracteres'
        ],
        'status' => [
            'required' => 'El estado es requerido',
            'in_list' => 'El estado debe ser active o inactive'
        ],
        'registered_by' => [
            'required' => 'El usuario que registra es requerido',
        ]
    ];

    protected $skipValidation = false;

    /**
     * Crear un nuevo negocio con validación de Entity
     */
    public function createBusiness(Business $business, $returnID = true): bool|int|UuidInterface
    {

        try {

            if ($business->id === null) $business->id = generate_uuid();

            $result = $this->insert($business);

            if ($result === false) {
                throw new DatabaseException('Error al insertar el negocio: ' . implode(', ', $this->errors()));
            }

            if ($returnID) return $business->id;

            return $result;
        } catch (\Exception $e) {
            log_message('error', 'Error creando negocio: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Actualizar un negocio existente
     */
    public function updateBusiness(UuidInterface|string $id, Business $business): bool
    {

        $bytes = uuid_to_bytes($id);

        $existing = $this->find($bytes);

        if (!$existing) {
            throw new \InvalidArgumentException('Negocio no encontrado');
        }

        try {
            return $this->update($bytes, $business);
        } catch (\Exception $e) {
            log_message('error', 'Error actualizando negocio: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Obtener negocio por ID
     */
    public function getBusiness(UuidInterface|string $id): ?Business
    {
        return $this->find(uuid_to_bytes($id));
    }

    /**
     * Obtener todos los negocios activos
     * @return array<Business>
     */
    public function getActiveBusinesses(): array
    {
        return $this->where('status', 'active')->findAll();
    }

    /**
     * Obtener negocios por usuario registrador
     * @return array<Business>
     */
    public function getBusinessesByUser(UuidInterface|string $userId): array
    {
        return $this->where('registered_by', uuid_to_bytes($userId))->findAll();
    }

    /**
     * Buscar negocios por nombre
     * @return array<Business>
     */
    public function searchByName(string $name): array
    {
        return $this->like('name', $name)->findAll();
    }

    /**
     * Cambiar estado de un negocio
     * @param string|'active'|'inactive' $status
     */
    public function changeStatus(int $id, string $status): bool
    {
        if (!in_array($status, ['active', 'inactive'])) {
            throw new \InvalidArgumentException('Estado inválido');
        }

        return $this->update($id, ['status' => $status]);
    }

    /**
     * Eliminar negocio (soft delete)
     */
    public function deleteBusiness(UuidInterface|string $id): bool
    {
        return $this->delete(uuid_to_bytes($id));
    }

    /**
     * Restaurar negocio eliminado
     */
    public function restoreBusiness(UuidInterface|string $id): bool
    {
        return $this->update(uuid_to_bytes($id), ['deleted_at' => null]);
    }

    /**
     * Obtener estadísticas de negocios
     */
    public function getBusinessStats(): array
    {
        $total = $this->countAll();
        $active = $this->where('status', 'active')->countAllResults(false);
        $inactive = $this->where('status', 'inactive')->countAllResults();

        return [
            'total' => $total,
            'active' => $active,
            'inactive' => $inactive
        ];
    }

    /**
     * Obtener negocios con paginación
     */
    public function getBusinessesPaginated(int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;

        $businesses = $this->findAll($perPage, $offset);
        $total = $this->countAll();

        return [
            'data' => $businesses,
            'total' => $total,
            'page' => $page,
            'per_page' => $perPage,
            'total_pages' => ceil($total / $perPage)
        ];
    }
}
