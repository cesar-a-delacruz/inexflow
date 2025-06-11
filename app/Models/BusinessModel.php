<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Business;
use CodeIgniter\Database\Exceptions\DatabaseException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class BusinessModel extends Model
{
    protected $table = 'businesses';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false;
    protected $returnType = Business::class;
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        // 'id',
        'business_name',
        'owner_name',
        'owner_email',
        'owner_phone',
        'status',
        'registered_by'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [
        'business_name' => 'required|max_length[255]',
        'owner_name' => 'required|max_length[255]',
        'owner_email' => 'required|valid_email|max_length[255]',
        'owner_phone' => 'permit_empty|max_length[50]',
        'status' => 'required|in_list[active,inactive]',
        'registered_by' => 'required'
    ];

    protected $validationMessages = [
        'business_name' => [
            'required' => 'El nombre del negocio es requerido',
            'max_length' => 'El nombre del negocio no puede exceder 255 caracteres'
        ],
        'owner_name' => [
            'required' => 'El nombre del propietario es requerido',
            'max_length' => 'El nombre del propietario no puede exceder 255 caracteres'
        ],
        'owner_email' => [
            'required' => 'El email del propietario es requerido',
            'valid_email' => 'Debe proporcionar un email válido',
            'max_length' => 'El email no puede exceder 255 caracteres'
        ],
        'owner_phone' => [
            'max_length' => 'El teléfono no puede exceder 50 caracteres'
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
    public function createBusiness(Business $business, $returnID = true): bool|int|string|UuidInterface
    {

        // Verificar email único
        if ($this->emailExists($business->owner_email)) {
            throw new \InvalidArgumentException('El email ya está registrado');
        }

        try {
            $result = $this->insert($business, $returnID);

            if ($result === false) {
                throw new DatabaseException('Error al insertar el negocio: ' . implode(', ', $this->errors()));
            }

            if ($returnID && is_string($result) && strlen($result) === 16) {
                return Uuid::fromBytes($result);
            }

            return $result;
        } catch (\Exception $e) {
            log_message('error', 'Error creando negocio: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Actualizar un negocio existente
     */
    public function updateBusiness(int $id, Business $business): bool
    {

        // Verificar que el negocio existe
        $existing = $this->find($id);
        if (!$existing) {
            throw new \InvalidArgumentException('Negocio no encontrado');
        }

        // Verificar email único (excluyendo el actual)
        if ($business->owner_email !== $existing->owner_email && $this->emailExists($business->owner_email)) {
            throw new \InvalidArgumentException('El email ya está registrado');
        }

        try {
            $data = $business->toArray();
            return $this->update($id, $data);
        } catch (\Exception $e) {
            log_message('error', 'Error actualizando negocio: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Obtener negocio por ID
     * @return array<Business>
     */
    public function getBusiness(UuidInterface $id): array
    {
        return $this->find($id);
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
    public function getBusinessesByUser(int $userId): array
    {
        return $this->where('registered_by', $userId)->findAll();
    }

    /**
     * Buscar negocios por nombre
     * @return array<Business>
     */
    public function searchByName(string $name): array
    {
        return $this->like('business_name', $name)->findAll();
    }

    /**
     * Obtener negocio por email del propietario
     */
    public function getBusinessByEmail(string $email): ?Business
    {
        return $this->where('owner_email', $email)->first();
    }

    /**
     * Cambiar estado de un negocio
     * @param string $status 'active', 'inactive'
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
    public function deleteBusiness(int $id): bool
    {
        return $this->delete($id);
    }

    /**
     * Restaurar negocio eliminado
     */
    public function restoreBusiness(int $id): bool
    {
        return $this->update($id, ['deleted_at' => null]);
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
     * Verificar si un email ya existe
     */
    private function emailExists(string $email): bool
    {
        return $this->where('owner_email', $email)->countAllResults() > 0;
    }

    /**
     * Obtener negocios con paginación
     * @return array<Business>
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
