<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Product extends Entity
{
    protected $datamap = [];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'id' => 'uuid',
        'business_id' => 'uuid',
        'category_number' => 'int',
        'name' => 'string',
        'description' => 'string',
        'sku' => 'string',
        'cost_price' => 'decimal',
        'selling_price' => 'decimal',
        'is_service' => 'boolean',
        'track_inventory' => 'boolean',
        'current_stock' => 'int',
        'min_stock_level' => 'int',
        'unit_of_measure' => 'string',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => '?datetime',
    ];

    protected $attributes = [
        'id' => null,
        'business_id' => null,
        'category_number' => null,
        'name' => null,
        'description' => null,
        'sku' => null,
        'cost_price' => 0.00,
        'selling_price' => null,
        'is_service' => false,
        'track_inventory' => true,
        'current_stock' => 0,
        'min_stock_level' => 0,
        'unit_of_measure' => 'unit',
        'is_active' => true,
    ];

    protected $castHandlers = [
        'uuid' => Cast\UuidCast::class
    ];
}
