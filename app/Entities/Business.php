<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Business extends Entity
{
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'id' => 'uuid',
        'name' => 'string',
        'phone' => 'string',
        'owner_id' => 'uuid',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => '?datetime',
    ];

    protected $castHandlers = [
        'uuid' => Cast\UuidCast::class
    ];
}
