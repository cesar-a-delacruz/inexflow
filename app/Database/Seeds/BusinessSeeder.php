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
            'business_name' => 'business a',
            'owner_name' => 'markus diaz',
            'owner_email' => 'markdi01@gmail.com',
            'owner_phone' => '66588901',
            'tax_id' => 'Emxksfvmfa12',
            'address' => 'Changuinola',
            'logo_url' => 'https://1000marcas.net/wp-content/uploads/2019/11/Instagram-Logo.jpg',
            'status' => 'active',
            'registered_by'=> Uuid::fromInteger('1'),
        ]));
        $model->createBusiness(new Business([
            'business_name' => 'business b',
            'owner_name' => 'michael jackson',
            'owner_email' => 'mich07@gmail.com',
            'owner_phone' => '65809012',
            'tax_id' => 'Bvgkhyvmdu36',
            'address' => 'Las Tablas',
            'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/24/LEGO_logo.svg/2048px-LEGO_logo.svg.png',
            'onboarding_completed' => false,
            'status' => 'active',
            'registered_by'=> Uuid::fromInteger('1'),
        ]));
    }
}
