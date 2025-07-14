<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Contact extends Entity
{
    protected $datamap = [];

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

    protected $attributes = [
        'id' => null,
        'business_id' => null,
        'name' => null,
        'email' => null,
        'phone' => null,
        'address' => null,
    ];

    protected $castHandlers = [
        'uuid' => Cast\UuidCast::class
    ];

    public function getTypeDisplayName(): string
    {
        return match ($this->type) {
            'customer' => 'Cliente',
            'provider' => 'Proveedor',
        };
    }
}
