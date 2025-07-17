<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Entities\Record;
use App\Models\RecordModel;
use Ramsey\Uuid\Uuid;

class RecordsSeeder extends Seeder
{
    public function run()
    {
        $model = new RecordModel();
        $model->insert(new Record([
            'transaction_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'description' => 'Empanada',
            'category' => 'Ventas',
            'amount' => 3,
            'subtotal' => 1.50,
        ]));
        $model->insert(new Record([
            'transaction_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '2'),
            'description' => 'Lavado de auto',
            'category' => 'Gastos Operativos',
            'amount' => null,
            'subtotal' => 20.00,
        ]));
        $model->insert(new Record([
            'transaction_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '3'),
            'description' => 'Artesanía',
            'category' => 'Ventas',
            'amount' => 4,
            'subtotal' => 30.75,
        ]));
    }
}
