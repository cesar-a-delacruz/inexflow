<?php

namespace App\Database\Seeds;

use App\Entities\Transaction;
use App\Models\TransactionModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;
use Ramsey\Uuid\Uuid;

class TransactionsSeeder extends Seeder
{
    public function run()
    {
        $model = new TransactionModel();
        $model->insert(new Transaction([
            'id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'business_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'contact_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'number' => strval(Time::now()->timestamp + 1),
            'due_date' => date('Y-m-d', Time::create(2026,3,10,7,10,0)->timestamp),
            'payment_status' => 'paid',
            'payment_method' => 'cash',
        ]));
        $model->insert(new Transaction([
            'id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '2'),
            'business_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'contact_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '2'),
            'number' => strval(Time::now()->timestamp + 2),
            'due_date' => date('Y-m-d', Time::create(2026,3,10)->timestamp),
            'payment_status' => 'pending',
            'payment_method' => null,
        ]));
        $model->insert(new Transaction([
            'id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '3'),
            'business_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'contact_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '3'),
            'number' => strval(Time::now()->timestamp + 3),
            'due_date' => date('Y-m-d', Time::create(2026,3,10)->timestamp),
            'payment_status' => 'overdue',
            'payment_method' => null,
        ]));
    }
}
