<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Entities\User;
use App\Models\UserModel;
use Ramsey\Uuid\Uuid;

class UserSeeder extends Seeder
{
    public function run()
    {
        $model = new UserModel();
        $model->createUser(new User([
            'id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'business_id' => null,
            'name' => 'root admin',
            'email' => 'root.admin@email.com',
            'password' => '1234',
            'role' => 'admin',
            'is_active' => 1,
        ]));
        $model->createUser(new User([
            'id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '2'),
            'business_id' => null,
            'name' => 'business owner',
            'email' => 'business.owner@email.com',
            'password' => '12345678',
            'role' => 'businessman',
            'is_active' => 0,
        ]));
    }
}
