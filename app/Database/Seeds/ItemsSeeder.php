<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Entities\Item;
use App\Enums\ItemType;
use App\Models\ItemModel;
use Ramsey\Uuid\Uuid;

class ItemsSeeder extends Seeder
{
    public function run()
    {
        $model = new ItemModel();
        $model->insert(new Item([
            'business_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'name' => 'Pollo',
            'type' => ItemType::Supply,
            'cost' => 0.75,
            'stock' => 8,
            'min_stock' => 3,
            'measure_unit_id' => 1,
        ]));
        $model->insert(new Item([
            'business_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'name' => 'Arroz',
            'type' => ItemType::Supply,
            'cost' => 0.64,
            'stock' => 8,
            'min_stock' => 4,
            'measure_unit_id' => 1,
        ]));
        $model->insert(new Item([
            'business_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'name' => 'Sopa d Pollo con arroz',
            'type' => ItemType::Product,
            'cost' => 4.00,
            'selling_price' => 5.50,
            'stock' => 15,
            'min_stock' => 3,
            'measure_unit_id' => 3,
        ]));
    }
}
