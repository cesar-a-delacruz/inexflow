<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Entities\Item;
use App\Entities\Service;
use App\Enums\ItemType;
use App\Enums\ServiceType;
use App\Models\ItemModel;
use App\Models\ServiceModel;
use Ramsey\Uuid\Uuid;

class ServicesSeeder extends Seeder
{
    public function run()
    {
        $model = new ServiceModel();
        $model->insert(new Service([
            'business_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'name' => 'Limpieza de Hollas',
            'type' => ServiceType::Expense,
            'cost' => 0.75,
            'selling_price' => 1.25,
            'measure_unit_id' => 6,
        ]));
        $model->insert(new Service([
            'business_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'name' => 'Luz',
            'type' => ServiceType::Income,
            'cost' => 0.89,
            'measure_unit_id' => 6,
        ]));
        $model->insert(new Service([
            'business_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'name' => 'Agua',
            'type' => ServiceType::Income,
            'cost' => 0.68,
            'measure_unit_id' => 6,
        ]));
        $model->insert(new Service([
            'business_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'name' => 'Gas',
            'type' => ServiceType::Income,
            'cost' => 1.47,
            'measure_unit_id' => 6,
        ]));
    }
}
