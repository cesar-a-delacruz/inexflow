<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Entities\Transaction;
use App\Models\TransactionsModel;
use DateTime;
use Ramsey\Uuid\Uuid;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        $model = new TransactionsModel();
        $model->createTransaction(new Transaction([
            'business_id' =>Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'category_number' => 1,
            'amount' => 120.00,
            'description' => 'Pago en Tienda',
            'transaction_date' => '2025-02-28',
            'payment_method' => 'cash',
            'notes' => null,
        ]));
        $model->createTransaction(new Transaction([
            'business_id' =>Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'category_number' => 2,
            'amount' => 140.00,
            'description' => 'Renta Mensual',
            'transaction_date' => '2024-12-31',
            'payment_method' => 'card',
            'notes' => 'Vivienda',
        ]));
        $model->createTransaction(new Transaction([
            'business_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'category_number' => 3,
            'amount' => 85.50,
            'description' => 'Consulta Médica',
            'transaction_date' => '2023-11-09',
            'payment_method' => 'transfer',
            'notes' => null,
        ]));
    }
}
