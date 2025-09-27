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
        $data = new Business([
            'id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'name' => 'Sopas de Aurora',
            'phone' => '6714-1802',
        ]);
        $model->insert($data);
    }
}
