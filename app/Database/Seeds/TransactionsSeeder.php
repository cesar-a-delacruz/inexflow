<?php

namespace App\Database\Seeds;

use App\Entities\Transaction;
use App\Enums\PaymentStatus;
use App\Enums\TransactionType;
use App\Models\TransactionModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;
use Ramsey\Uuid\Uuid;

class TransactionsSeeder extends Seeder
{
    public function run()
    {
        $model = new TransactionModel();
        // Incomes - Ordenes 
        $model->insertBatch([
            new Transaction([
                'number' => strval(Time::now()->timestamp + 1),
                'contact_id' => 1, //cesar
                'payment_status' => PaymentStatus::Pending,
                'description' => 'Debe de entregarse en su casa, no se por que jajaja',
                'total' => 25.36,
                'type' => TransactionType::Income,
                'due_date' => date('Y-m-d', Time::create(2026, 3, 10, 7, 10, 0)->timestamp),
                'business_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            ]),
        ]);
    }
}
