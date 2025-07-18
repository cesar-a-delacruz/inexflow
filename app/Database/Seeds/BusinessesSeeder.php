<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Entities\Business;
use App\Models\BusinessModel;
use Ramsey\Uuid\Uuid;

class BusinessesSeeder extends Seeder
{
    public function run()
    {
        $model = new BusinessModel();
        $model->insert(new Business([
            'id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'name' => 'business a',
            'phone' => '66667777',
            'owner_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '2'),
        ]));
    }
}
