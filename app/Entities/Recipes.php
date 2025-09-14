<?php

namespace App\Entities;

use App\Entities\AuditableEntity;

class Recipes extends AuditableEntity
{
    protected $tenant = true;

    protected $casts = [
        'id' => 'int',
        'product_id' => 'int',
        'ingredient_id' => 'int',
        'measure_unit_id' => 'int',
        'quantity' => 'int'
    ];
}
