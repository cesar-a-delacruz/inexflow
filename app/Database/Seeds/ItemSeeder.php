<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Entities\Item;
use App\Models\ItemModel;
use Ramsey\Uuid\Uuid;

class ItemSeeder extends Seeder
{
    public function run()
    {
        $model = new ItemModel();
        $model->insert(new Item([
            'id' =>Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'business_id' =>Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'category_number' => 1,
            'name' => 'Empanada',
            'type' => 'product',
            'cost' => 0.50,
            'selling_price' => 0.75,
            'current_stock' => 20,
            'min_stock' => 5,
            'measure_unit' => 'Unidad',
            'is_active' => 1,
        ]));
        $model->insert(new Item([
            'id' =>Uuid::uuid3(Uuid::NAMESPACE_URL, '2'),
            'business_id' =>Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'category_number' => 2,
            'name' => 'Gas',
            'type' => 'product',
            'cost' => 60.00,
            'selling_price' => null,
            'current_stock' => 2,
            'min_stock' => 1,
            'measure_unit' => 'Unidad',
            'is_active' => 1,
        ]));
        $model->insert(new Item([
            'id' =>Uuid::uuid3(Uuid::NAMESPACE_URL, '3'),
            'business_id' =>Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'category_number' => 3,
            'name' => 'Agua',
            'type' => 'service',
            'cost' => 40.00,
            'selling_price' => null,
            'current_stock' => null,
            'min_stock' => null,
            'measure_unit' => null,
            'is_active' => 1,
        ]));
    }
}
