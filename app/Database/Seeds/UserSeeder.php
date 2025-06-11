<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'business_id' => null,
                'name' => 'root admin',
                'email' => 'root.admin@email.com',
                'password' => '1234',
                'role' => 'admin',
                'is_active' => true,
            ],
            [
                'business_id' => 1,
                'name' => 'business owner',
                'email' => 'business.owner@email.com',
                'password' => '12345678',
                'role' => 'businessman',
                'is_active' => false,
            ],
        ];
        $this->db->table('users')->insertBatch($data);
    }
}
