<?php

namespace App\Controllers\Tenants;

use App\Enums\TransactionType;

class IncomeServicesController extends ServiceController
{
    public function __construct()
    {
        parent::__construct(TransactionType::Income);
    }
}
