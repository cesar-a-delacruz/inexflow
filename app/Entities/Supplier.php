<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Supplier extends Entity
{
    protected $datamap = [];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'id' => 'uuid',
        'business_id' => 'uuid',
        'name' => 'string',
        'contact_person' => 'string',
        'email' => 'string',
        'phone' => 'string',
        'address' => 'string',
        'tax_id' => 'string',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => '?datetime',
    ];

    protected $attributes = [
        'id' => null,
        'business_id' => null,
        'name' => null,
        'contact_person' => null,
        'email' => null,
        'phone' => null,
        'address' => null,
        'tax_id' => null,
        'is_active' => true,
    ];

    protected $castHandlers = [
        'uuid' => Cast\UuidCast::class
    ];
}
