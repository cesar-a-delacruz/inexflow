<?php

namespace App\Controllers\Tenants;

use App\Enums\ContactType;

class CustomerController extends ContactController
{
    public function __construct()
    {
        parent::__construct(ContactType::Customer);
    }
}
