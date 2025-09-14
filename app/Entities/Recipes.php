<?php

namespace App\Entities;

use App\Entities\Cast\UuidCast;
use CodeIgniter\Entity\Entity;

class Recipes extends Entity
{

    protected $castHandlers = [
        'uuid' => UuidCast::class,
    ];
    protected $casts = [
        'id' => 'int',
        'product_id' => 'int',
        'ingredient_id' => 'int',
        'measure_unit_id' => 'int',
        'quantity' => 'int',
        'business_id' => 'uuid',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
        'deleted_at'  => '?datetime'
    ];
}
