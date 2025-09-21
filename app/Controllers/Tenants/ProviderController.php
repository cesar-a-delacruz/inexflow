<?php

namespace App\Controllers\Tenants;

use App\Enums\ContactType;

class ProviderController extends ContactController
{
    public function __construct()
    {
        parent::__construct(ContactType::Provider);
    }
}
