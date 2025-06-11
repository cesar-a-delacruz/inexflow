<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Business extends Entity
{
    protected $datamap = [];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'id' => 'uuid',
        'registered_by' => 'uuid',
        'status' => 'string',
        'business_name' => 'string',
        'owner_name' => 'string',
        'owner_email' => 'string',
        'owner_phone' => '?string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => '?datetime',
    ];

    protected $attributes = [
        'id' => null,
        'business_name' => null,
        'owner_name' => null,
        'owner_email' => null,
        'owner_phone' => null,
        'status' => 'active',
        'registered_by' => null,
    ];

    protected $castHandlers = [
        'uuid' => Cast\UuidCast::class
    ];
}
