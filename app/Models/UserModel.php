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

    public function findByEmail(string $email): ?User
    {
        return $this->where('email', $email)->first();
    }

    public function emailUnique($email, $user_id): bool
    {
        return $this->where('email', $email)->whereNotIn('id', [$user_id])->countAllResults() > 0;
    }

    public function toggleActive($id): bool
    {
        $id = uuid_to_bytes($id);
        $user = $this->find($id);
        return $this->update($id, ['is_active' => !$user->is_active]);
    }
}
