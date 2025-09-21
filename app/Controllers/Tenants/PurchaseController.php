<?php

namespace App\Controllers\Tenants;

use App\Enums\TransactionType;

class PurchaseController extends TransactionController
{
    public function __construct()
    {
        parent::__construct(TransactionType::Expense);
    }
}
