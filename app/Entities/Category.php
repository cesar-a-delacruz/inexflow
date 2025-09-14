<?php

namespace App\Entities;

use App\Entities\AuditableEntity;

class Category extends AuditableEntity
{

    protected $casts = [
        'id' => 'int',
        'business_id' => 'uuid',
        'name' => 'string',
    ];

    protected $castHandlers = [
        'uuid' => Cast\UuidCast::class,

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
