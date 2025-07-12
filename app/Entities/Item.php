<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Item extends Entity
{
    protected $datamap = [];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'id' => 'uuid',
        'business_id' => 'uuid',
        'category_number' => 'int',
        'name' => 'string',
        'type' => 'string',
        'cost' => 'float',
        'selling_price' => 'float',
        'current_stock' => 'int',
        'min_stock' => 'int',
        'measure_unit' => 'string',
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
        'type' => 'product',
        'cost' => 0.00,
        'selling_price' => null,
        'current_stock' => 0,
        'min_stock' => 0,
        'measure_unit' => 'unidad',
        'is_active' => 1,
    ];

    protected $castHandlers = [
        'uuid' => Cast\UuidCast::class
    ];

    public function getTypeDisplayName(): string
    {
        return match ($this->type) {
            'service' => 'Servicio',
            'product' => 'Producto  ',
        };
    }
    public function getCategoryTypeDisplayName(): string
    {
        return match ($this->category_type) {
            'income' => 'Ingreso',
            'expense' => 'Gasto',
        };
    }
}
