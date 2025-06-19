<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Entities\Categories;
use App\Models\CategoriesModel;
use Ramsey\Uuid\Uuid;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $model = new CategoriesModel();
        $model->createCategories(new Categories([
            'business_id' =>Uuid::uuid3(Uuid::NAMESPACE_URL, '2'),
            'category_number' => 1,
            'name' => 'Ventas',
            'type' => 'income',
            'is_active' => 1,
        ]));
        $model->createCategories(new Categories([
            'business_id' =>Uuid::uuid3(Uuid::NAMESPACE_URL, '2'),
            'category_number' => 2,
            'name' => 'Gastos Operativos',
            'type' => 'expense',
            'is_active' => 1,
        ]));
        $model->createCategories(new Categories([
            'business_id' =>Uuid::uuid3(Uuid::NAMESPACE_URL, '2'),
            'category_number' => 3,
            'name' => 'Costo de Fabricación',
            'type' => 'expense',
            'is_active' => 0,
        ]));
    }
}