<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Category extends Entity
{
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'id' => 'integer',
        'business_id' => 'uuid',
        'name' => 'string',
        'type' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => '?datetime',
    ];

    protected $castHandlers = [
        'uuid' => Cast\UuidCast::class
    ];

    /** Muestra el tipo de categoría en español */
    public function displayType(): string
    {
        return match ($this->type) {
            'income' => 'Ingreso',
            'expense' => 'Gasto',
        };
    }
}
