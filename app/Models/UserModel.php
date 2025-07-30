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

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    /** Busca un usuario por su correo */
    public function findByEmail(string $email): ?User
    {
        return $this->where('email', $email)->first();
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
