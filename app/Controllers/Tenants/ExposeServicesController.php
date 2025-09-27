<?php

namespace App\Controllers\Tenants;

use App\Enums\TransactionType;

class ExposeServicesController extends ServiceController
{
    public function __construct()
    {
        parent::__construct(TransactionType::Expense);
    }
}
