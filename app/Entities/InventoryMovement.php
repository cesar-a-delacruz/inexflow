<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class InventoryMovement extends Entity
{
    protected $datamap = [];

    protected $dates = ['created_at'];

    protected $casts = [
        'id' => 'int',
        'business_id' => 'uuid',
        'product_id' => 'uuid',
        'movement_type' => 'string',
        'quantity' => 'int',
        'unit_cost' => '?decimal',
        'reference_type' => '?string',
        'reference_id' => '?int',
        'notes' => '?string',
        'created_by' => 'uuid',
        'created_at' => 'datetime',
    ];

    protected $attributes = [
        'id' => null,
        'business_id' => null,
        'product_id' => null,
        'movement_type' => null,
        'quantity' => null,
        'unit_cost' => null,
        'reference_type' => null,
        'reference_id' => null,
        'notes' => null,
        'created_by' => null,
    ];

    protected $castHandlers = [
        'uuid' => Cast\UuidCast::class
    ];
}
