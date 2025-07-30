<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Contact extends Entity
{
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'id' => 'uuid',
        'business_id' => 'uuid',
        'name' => 'string',
        'email' => 'string',
        'phone' => 'string',
        'address' => 'string',
        'type' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => '?datetime',
    ];

    protected $castHandlers = [
        'uuid' => Cast\UuidCast::class
    ];

    /** Muestra el tipo de contacto en español */
    public function displayType(): string
    {
        return match ($this->type) {
            'customer' => 'Cliente',
            'provider' => 'Proveedor',
        };
    }
}
