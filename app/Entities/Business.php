<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Business extends Entity
{
    protected $datamap = [];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'id' => 'uuid',
        'name' => 'string',
        'phone' => 'string',
        'status' => 'string',
        'owner_id' => 'uuid',
        'registered_by' => 'uuid',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => '?datetime',
    ];

    protected $attributes = [
        'id' => null,
        'name' => null,
        'phone' => null,
        'owner_id' => null,
        'status' => 'active',
        'registered_by' => null,
    ];

    protected $castHandlers = [
        'uuid' => Cast\UuidCast::class
    ];
}
