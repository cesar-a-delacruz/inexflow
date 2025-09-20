<?php

namespace App\Controllers\Tenants;

use App\Enums\TransactionType;

class OrderController extends TransactionController
{
    public function __construct()
    {
        parent::__construct(TransactionType::Income);
    }
}
