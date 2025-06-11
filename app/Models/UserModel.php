<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\User;
use CodeIgniter\Database\Exceptions\DatabaseException;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = User::class;
    protected $useSoftDeletes   = true;

    protected $allowedFields = [
        // 'id',
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
        'password_hash' => 'required|max_length[60]',
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
        'password_hash' => [
            'required' => 'la contrasena no puede star basia',
            'max_length' => 'la contrasena no puede sre mas grande que 60 caracteres',
        ],
        'role' => [
            'required' => 'El rol es requerido',
            'in_list' => 'El rol debe ser admin o businessman'
        ],
        'business_id' => [],
        'is_active' => [
            'in_list' => 'Solo puede estar desactivado o activado'
        ]
    ];

    protected $skipValidation = false;

    /**
     * Crear un nuevo usuario con validación de Entity
     */
    public function createUser(User $user): int|false
    {

        // Verificar email único
        if ($this->userEmailExists($user->email)) {
            throw new \InvalidArgumentException('El email ya está registrado');
        }

        try {
            // $data = $business->toArray();
            $result = $this->insert($user);

            if ($result === false) {
                throw new DatabaseException('Error al insertar el usuario: ' . implode(', ', $this->errors()));
            }

            return $result;
        } catch (\Exception $e) {
            log_message('error', 'Error creando usuario: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Actualizar un usuario existente
     */
    public function updateUser(int $id, User $user): bool
    {

        // Verificar que el negocio existe
        $existing = $this->find($id);
        if (!$existing) {
            throw new \InvalidArgumentException('Usuario no encontrado');
        }

        // Verificar email único (excluyendo el actual)
        if ($user->email !== $existing->email && $this->emailExists($user->email)) {
            throw new \InvalidArgumentException('El email ya está registrado');
        }

        try {
            return $this->update($id, $user);
        } catch (\Exception $e) {
            log_message('error', 'Error actualizando usuario: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Busca un usuario por email
     */
    public function findByEmail(string $email): ?User
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Verificar si un email ya existe
     */
    private function userEmailExists(string $email): bool
    {
        return $this->where('email', $email)->countAllResults() > 0;
    }

    /**
     * Verificar si un name ya existe
     */
    private function userNameExists(string $name): bool
    {
        return $this->where('name', $name)->countAllResults() > 0;
    }

    /**
     * Busca un usuario por email y business_id
     */
    public function findByEmailAndBusiness(string $email, int $businessId): ?User
    {
        $builder = $this->where('email', $email);

        if ($businessId) {
            $builder->where('business_id', $businessId);
        } else {
            $builder->where('business_id IS NULL');
        }

        return $builder->first();
    }

    /**
     * Obtiene usuarios por rol
     * @return array<User>
     */
    public function findByRole(string $role): array
    {
        return $this->where('role', $role)->findAll();
    }

    /**
     * Obtiene usuarios activos
     * @return array<User>
     */
    public function findActive(): array
    {
        return $this->where('is_active', true)->findAll();
    }

    /**
     * Obtiene usuarios por business_id
     * @return array<User>
     */
    public function findByBusiness(int $businessId): array
    {

        return $this->where('business_id', $businessId)->findAll();
    }

    /**
     * Busca usuarios por business_id y rol
     * @return array<User>
     */
    public function findByBusinessAndRole(int $businessId, string $role): array
    {

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
    public function toggleActive(int $id): bool
    {
        $user = $this->find($id);
        if (!$user) {
            return false;
        }

        return $this->update($id, ['is_active' => !$user->is_active]);
    }

    /**
     * Cambia la contraseña de un usuario
     */
    public function changePassword(int $id, string $newPassword): bool
    {
        return $this->update($id, ['password_hash' => $newPassword]);
    }

    /**
     * Verifica si un email existe (excluyendo un ID específico)
     */
    public function emailExists(string $email, $excludeId = null, $businessId = null): bool
    {
        $builder = $this->where('email', $email);

        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }

        if ($businessId) {

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
}
