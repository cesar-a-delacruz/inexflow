<?php

namespace App\Models;

use App\Entities\User;
use App\Models\EntityModel;

/**
 * @extends EntityModel<User>
 */
class UserModel extends EntityModel
{
    protected $table            = 'users';
    protected $returnType       = User::class;

    protected $allowedFields = [
        'id',
        'name',
        'email',
        'password_hash',
        'role',
        'business_id',
        'is_active'
    ];

    /** Busca un usuario por su correo */
    public function findByEmail(string $email): ?User
    {
        return $this->where('email', $email)->first();
    }
    /**
     * @return array<User>
     */
    public function findAllByBusiness(string $businessId): array
    {
        return $this->where('business_id', uuid_to_bytes($businessId))->findAll();
    }

    /** Verifica si el conteo de usuarios con el correo y que no tengan el id brindados es mayor a 0 */
    public function emailUnique(string $email, string $user_id): bool
    {
        return $this->where('email', $email)->whereNotIn('id', [uuid_to_bytes($user_id)])->countAllResults() > 0;
    }

    /** Activa o desactiva el usuario con el id brindado */
    public function toggleActive(string $id): bool
    {
        $id = uuid_to_bytes($id);
        $user = $this->find($id);
        return $this->update($id, ['is_active' => !$user->is_active]);
    }
}
