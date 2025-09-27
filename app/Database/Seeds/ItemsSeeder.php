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

        //SUMINISTROS
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
        $model->insertBatch([
            new Item([
                'business_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
                'name' => 'Yuca',
                'type' => ItemType::Supply,
                'cost' => 0.85,
                'stock' => 4,
                'min_stock' => 4,
                'measure_unit_id' => 1,
            ]),
            new Item([
                'business_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
                'name' => 'Otoe',
                'type' => ItemType::Supply,
                'cost' => 0.95,
                'stock' => 8,
                'min_stock' => 4,
                'measure_unit_id' => 1,
            ]),
            new Item([
                'business_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
                'name' => 'Vaso de sopa',
                'type' => ItemType::Supply,
                'cost' => 1.25,
                'stock' => 8,
                'min_stock' => 4,
                'measure_unit_id' => 4,
            ]),
            new Item([
                'business_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
                'name' => 'Cucharas',
                'type' => ItemType::Supply,
                'cost' => 1,
                'stock' => 8,
                'min_stock' => 8,
                'measure_unit_id' => 4,
            ])
        ]);

        // PRODUCTOS
        $model->insertBatch([
            new Item([
                'business_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
                'name' => 'Sopa de Pollo con arroz',
                'type' => ItemType::Product,
                'cost' => 4.00,
                'selling_price' => 5.50,
                'stock' => 15,
                'min_stock' => 3,
                'measure_unit_id' => 3,
            ]),
            new Item([
                'business_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
                'name' => 'Sopa de Pollo',
                'type' => ItemType::Product,
                'cost' => 3.70,
                'selling_price' => 5.25,
                'stock' => 10,
                'min_stock' => 15,
                'measure_unit_id' => 3,
            ]),
            new Item([
                'business_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
                'name' => 'Sopa de Pata',
                'type' => ItemType::Product,
                'cost' => 4.50,
                'selling_price' => 5.75,
                'stock' => 8,
                'min_stock' => 15,
                'measure_unit_id' => 3,
            ]),
            new Item([
                'business_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
                'name' => 'Sopa de Pata con arroz',
                'type' => ItemType::Product,
                'cost' => 4.75,
                'selling_price' => 5.70,
                'stock' => 6,
                'min_stock' => 3,
                'measure_unit_id' => 3,
            ]),
            new Item([
                'business_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
                'name' => 'Limonada',
                'type' => ItemType::Product,
                'cost' => 0.50,
                'selling_price' => 0.75,
                'stock' => 20,
                'min_stock' => 15,
                'measure_unit_id' => 3,
            ]),
        ]);
    }
}
