<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Entities\Category;
use App\Models\CategoryModel;
use Ramsey\Uuid\Uuid;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        $model = new CategoryModel();
        $model->insert(new Category([
            'business_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'name' => 'Ventas',
            'type' => 'income',
        ]));
        $model->insert(new Category([
            'business_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'name' => 'Gastos Operativos',
            'type' => 'expense',
        ]));
        $model->insert(new Category([
            'business_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'name' => 'Costo de Fabricación',
            'type' => 'expense',
        ]));
    }
}