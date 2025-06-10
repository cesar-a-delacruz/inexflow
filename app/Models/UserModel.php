<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\User;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = User::class;
    protected $useSoftDeletes   = true;

    protected $allowedFields = [
        'id',
        'name',
        'email',
        'password_hash',
        'role',
        'business_id',
        'is_active'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'name'     => 'required|max_length[255]',
        'email'    => 'required|valid_email|max_length[255]',
        'password_hash' => 'permit_empty|max_length[60]',
        'role'     => 'required|in_list[admin,businessman]',
        'business_id' => 'permit_empty',
        'is_active' => 'permit_empty|in_list[0,1]'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'El nombre es requerido',
            'max_length' => 'El nombre no puede exceder 255 caracteres'
        ],
        'email' => [
            'required' => 'El email es requerido',
            'valid_email' => 'Debe proporcionar un email válido',
            'max_length' => 'El email no puede exceder 255 caracteres'
        ],
        'role' => [
            'required' => 'El rol es requerido',
            'in_list' => 'El rol debe ser admin o businessman'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['generateUuid', 'hashPassword'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['hashPassword'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Genera UUID antes de insertar
     */
    protected function generateUuid(array $data)
    {
        if (empty($data['data']['id'])) {
            // Crear el UUID como objeto UuidInterface
            // El cast lo convertirá a binario automáticamente al guardar
            $data['data']['id'] = \Ramsey\Uuid\Uuid::uuid4();
        }
        return $data;
    }

    /**
     * Hashea la contraseña si está presente
     */
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password']) && !empty($data['data']['password'])) {
            $data['data']['password_hash'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
            unset($data['data']['password']);
        }
        return $data;
    }

    /**
     * Busca un usuario por email
     */
    public function findByEmail(string $email): ?User
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Busca un usuario por email y business_id
     */
    public function findByEmailAndBusiness(string $email, $businessId = null): ?User
    {
        $builder = $this->where('email', $email);

        if ($businessId) {
            // Si businessId es string UUID, convertirlo
            if (is_string($businessId) && \Ramsey\Uuid\Uuid::isValid($businessId)) {
                $businessId = \Ramsey\Uuid\Uuid::fromString($businessId);
            }
            $builder->where('business_id', $businessId);
        } else {
            $builder->where('business_id IS NULL');
        }

        return $builder->first();
    }

    /**
     * Obtiene usuarios por rol
     */
    public function findByRole(string $role): array
    {
        return $this->where('role', $role)->findAll();
    }

    /**
     * Obtiene usuarios activos
     */
    public function findActive(): array
    {
        return $this->where('is_active', true)->findAll();
    }

    /**
     * Obtiene usuarios por business_id
     */
    public function findByBusiness($businessId): array
    {
        // Si businessId es string UUID, convertirlo
        if (is_string($businessId) && \Ramsey\Uuid\Uuid::isValid($businessId)) {
            $businessId = \Ramsey\Uuid\Uuid::fromString($businessId);
        }

        return $this->where('business_id', $businessId)->findAll();
    }

    /**
     * Busca usuarios por business_id y rol
     */
    public function findByBusinessAndRole($businessId, string $role): array
    {
        // Si businessId es string UUID, convertirlo
        if (is_string($businessId) && \Ramsey\Uuid\Uuid::isValid($businessId)) {
            $businessId = \Ramsey\Uuid\Uuid::fromString($businessId);
        }

        return $this->where('business_id', $businessId)
            ->where('role', $role)
            ->findAll();
    }

    /**
     * Cuenta usuarios por rol
     */
    public function countByRole(string $role): int
    {
        return $this->where('role', $role)->countAllResults();
    }

    /**
     * Activa o desactiva un usuario
     */
    public function toggleActive($id): bool
    {
        // Si id es string UUID, convertirlo
        if (is_string($id) && \Ramsey\Uuid\Uuid::isValid($id)) {
            $id = \Ramsey\Uuid\Uuid::fromString($id);
        }

        $user = $this->find($id);
        if (!$user) {
            return false;
        }

        return $this->update($id, ['is_active' => !$user->is_active]);
    }

    /**
     * Cambia la contraseña de un usuario
     */
    public function changePassword($id, string $newPassword): bool
    {
        // Si id es string UUID, convertirlo
        if (is_string($id) && \Ramsey\Uuid\Uuid::isValid($id)) {
            $id = \Ramsey\Uuid\Uuid::fromString($id);
        }

        return $this->update($id, ['password' => $newPassword]);
    }

    /**
     * Verifica si un email existe (excluyendo un ID específico)
     */
    public function emailExists(string $email, $excludeId = null, $businessId = null): bool
    {
        $builder = $this->where('email', $email);

        if ($excludeId) {
            // Si excludeId es string UUID, convertirlo
            if (is_string($excludeId) && \Ramsey\Uuid\Uuid::isValid($excludeId)) {
                $excludeId = \Ramsey\Uuid\Uuid::fromString($excludeId);
            }
            $builder->where('id !=', $excludeId);
        }

        if ($businessId) {
            // Si businessId es string UUID, convertirlo
            if (is_string($businessId) && \Ramsey\Uuid\Uuid::isValid($businessId)) {
                $businessId = \Ramsey\Uuid\Uuid::fromString($businessId);
            }
            $builder->where('business_id', $businessId);
        } else {
            $builder->where('business_id IS NULL');
        }

        return $builder->countAllResults() > 0;
    }

    /**
     * Obtiene estadísticas de usuarios
     */
    public function getStats(): array
    {
        return [
            'total' => $this->countAll(),
            'active' => $this->where('is_active', true)->countAllResults(),
            'inactive' => $this->where('is_active', false)->countAllResults(),
            'admins' => $this->where('role', 'admin')->countAllResults(),
            'businessmen' => $this->where('role', 'businessman')->countAllResults(),
            'deleted' => $this->onlyDeleted()->countAllResults()
        ];
    }

    /**
     * Búsqueda avanzada de usuarios
     */
    public function search(array $filters = []): array
    {
        $builder = $this;

        if (!empty($filters['name'])) {
            $builder = $builder->like('name', $filters['name']);
        }

        if (!empty($filters['email'])) {
            $builder = $builder->like('email', $filters['email']);
        }

        if (!empty($filters['role'])) {
            $builder = $builder->where('role', $filters['role']);
        }

        if (isset($filters['is_active'])) {
            $builder = $builder->where('is_active', $filters['is_active']);
        }

        if (!empty($filters['business_id'])) {
            // Si business_id es string UUID, convertirlo
            if (is_string($filters['business_id']) && \Ramsey\Uuid\Uuid::isValid($filters['business_id'])) {
                $filters['business_id'] = \Ramsey\Uuid\Uuid::fromString($filters['business_id']);
            }
            $builder = $builder->where('business_id', $filters['business_id']);
        }

        // Ordenamiento
        $orderBy = $filters['order_by'] ?? 'created_at';
        $orderDir = $filters['order_dir'] ?? 'DESC';
        $builder = $builder->orderBy($orderBy, $orderDir);

        // Paginación
        if (!empty($filters['limit'])) {
            $offset = $filters['offset'] ?? 0;
            $builder = $builder->limit($filters['limit'], $offset);
        }

        return $builder->findAll();
    }
}
