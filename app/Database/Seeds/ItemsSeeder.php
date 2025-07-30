<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Entities\Item;
use App\Models\ItemModel;
use Ramsey\Uuid\Uuid;

class ItemsSeeder extends Seeder
{
    public function run()
    {
        $model = new ItemModel();
        $model->insert(new Item([
            'id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'business_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'category_id' => 1,
            'name' => 'Empanada',
            'type' => 'product',
            'cost' => 0.50,
            'selling_price' => 0.75,
            'stock' => 20,
            'min_stock' => 5,
            'measure_unit' => 'Unidad',
        ]));
        $model->insert(new Item([
            'id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '2'),
            'business_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'category_id' => 2,
            'name' => 'Gas',
            'type' => 'product',
            'cost' => 60.00,
            'selling_price' => null,
            'stock' => 2,
            'min_stock' => 1,
            'measure_unit' => 'Unidad',
        ]));
        $model->insert(new Item([
            'id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '3'),
            'business_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'category_id' => 3,
            'name' => 'Agua',
            'type' => 'service',
            'cost' => 40.00,
            'selling_price' => null,
            'stock' => null,
            'min_stock' => null,
            'measure_unit' => null,
        ]));
    }
}
