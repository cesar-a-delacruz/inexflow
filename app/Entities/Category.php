<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Category extends Entity
{
    protected $datamap = [];

    protected $attributes = [
        'business_id'     => null,
        'category_number' => null,
        'name'            => null,
        'type'            => null,
        'is_active'       => 1,
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'business_id'     => 'uuid',
        'category_number' => 'integer',
        'name'            => 'string',
        'type'            => 'string',
        'is_active'       => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => '?datetime',
    ];

    protected $castHandlers = [
        'uuid' => Cast\UuidCast::class
    ];

    public function isActive(): bool
    {
        return $this->is_active === true;
    }

    public function isDeleted(): bool
    {
        return $this->deleted_at !== null;
    }

    public function getTypeDisplayName(): string
    {
        return match ($this->type) {
            'income' => 'Ingreso',
            'expense' => 'Gasto',
            'product' => 'Product',
        };
    }
}
