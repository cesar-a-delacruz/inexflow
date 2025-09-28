<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Entities\User;
use App\Enums\UserRole;
use App\Models\UserModel;
use Ramsey\Uuid\Uuid;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $model = new UserModel();
        $model->insert(new User([
            'id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'name' => 'Cesar de la cruz',
            'email' => 'administrador@email.com',
            'password' => '1234',
            'role' => UserRole::Admin,
            'is_active' => true,
        ]));
        $model->insert(new User([
            'id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '2'),
            'business_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'name' => 'Yoseph arauz',
            'email' => 'empresario@email.com',
            'password' => '1234',
            'role' => UserRole::Businessman,
            'is_active' => true,
        ]));
    }
}
