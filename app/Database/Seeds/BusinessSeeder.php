<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Entities\Business;
use App\Models\BusinessModel;
use Ramsey\Uuid\Uuid;

class BusinessSeeder extends Seeder
{
    public function run()
    {
        $model = new BusinessModel();
        $model->createBusiness(new Business([
            'id' =>Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'name' => 'business a',
            'phone' => '66667777',
            'owner_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '2'),
            'registered_by'=> Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
        ]));
        $model->createBusiness(new Business([
            'id' =>Uuid::uuid3(Uuid::NAMESPACE_URL, '2'),
            'name' => 'business b',
            'phone' => '88889999',
            'owner_id' => null,
            'status' => 'inactive',
            'registered_by'=> Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
        ]));
    }
}
