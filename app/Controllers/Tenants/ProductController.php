<?php

namespace App\Controllers\Tenants;

use App\Enums\ItemType;

class ProductController extends ItemController
{
    public function __construct()
    {
        parent::__construct(ItemType::Product);
    }
}
