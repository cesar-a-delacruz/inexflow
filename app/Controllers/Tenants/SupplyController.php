<?php

namespace App\Controllers\Tenants;

use App\Enums\ItemType;

class supplyController extends ItemController
{
    public function __construct()
    {
        parent::__construct(ItemType::Supply);
    }
}
