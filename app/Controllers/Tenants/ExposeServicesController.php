<?php

namespace App\Controllers\Tenants;

use App\Enums\ServiceType;

class ExposeServicesController extends ServiceController
{
    public function __construct()
    {
        parent::__construct(ServiceType::Expense);
    }
}
