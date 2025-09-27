<?php

namespace App\Entities;

use App\Entities\Cast\EnumCast;
use App\Entities\Cast\UuidCast;
use CodeIgniter\Entity\Entity;

class Contact extends Entity
{
    protected $castHandlers = [
        'enum' => EnumCast::class,
        'uuid' => UuidCast::class,
    ];

    protected $casts = [
        'id' => 'int',
        'name' => 'string',
        'email' => '?string',
        'phone' => '?string',
        'address' => '?string',
        'type' => 'enum[App\Enums\ContactType]',
        'business_id' => 'uuid',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
        'deleted_at'  => '?datetime'
    ];
}
