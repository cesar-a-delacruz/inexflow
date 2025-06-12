<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Entities\Business;
use App\Models\BusinessModel;
use App\Models\BussinessModel;
use Ramsey\Uuid\Uuid;

class BusinessSeeder extends Seeder
{
    public function run()
    {
        $model = new BusinessModel();
        $model->createBusiness(new Business([
            'id' =>Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'business_name' => 'business a',
            'owner_name' => 'markus diaz',
            'owner_email' => 'markdi01@gmail.com',
            'owner_phone' => '66588901',
            'registered_by'=> Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
        ]));
        $model->createBusiness(new Business([
            'id' =>Uuid::uuid3(Uuid::NAMESPACE_URL, '2'),
            'business_name' => 'business b',
            'owner_name' => 'michael jackson',
            'owner_email' => 'mich07@gmail.com',
            'owner_phone' => '65809012',
            'status' => 'active',
            'registered_by'=> Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
        ]));
    }
}
