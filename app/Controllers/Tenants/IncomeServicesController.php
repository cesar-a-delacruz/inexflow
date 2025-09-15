<?php

namespace App\Controllers\Tenants;

use App\Enums\ServiceType;

class IncomeServicesController extends ServiceController
{
    public function __construct()
    {
        parent::__construct(ServiceType::Income);
    }
}
