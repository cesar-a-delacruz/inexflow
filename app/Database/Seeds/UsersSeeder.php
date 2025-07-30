<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Entities\User;
use App\Models\UserModel;
use Ramsey\Uuid\Uuid;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $model = new UserModel();
        $model->insert(new User([
            'id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'business_id' => null,
            'name' => 'root admin',
            'email' => 'root.admin@email.com',
            'password' => '1234',
            'role' => 'admin',
            'is_active' => true,
        ]));
        $model->insert(new User([
            'id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '2'),
            'business_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'name' => 'active owner',
            'email' => 'active.owner@email.com',
            'password' => '12345678',
            'role' => 'businessman',
            'is_active' => true,
        ]));
        $model->insert(new User([
            'id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '3'),
            'business_id' => null,
            'name' => 'inactive owner',
            'email' => 'inactive.owner@email.com',
            'password' => '12345678',
            'role' => 'businessman',
            'is_active' => false,
        ]));
    }
}
