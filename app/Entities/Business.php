<?php

namespace App\Entities;

use App\Entities\AuditableEntity;

class Business extends AuditableEntity
{

    protected $casts = [
        'id' => 'uuid',
        'name' => 'string',
        'phone' => 'string',
    ];

    protected $castHandlers = [
        'uuid' => Cast\UuidCast::class
    ];
}
