<?php

namespace App\Entities;

use App\Entities\AuditableEntity;
use App\Entities\Cast\EnumCast;

class Contact extends AuditableEntity
{
    protected $tenant = true;

    protected $casts = [
        'id' => 'int',
        'name' => 'string',
        'email' => '?string',
        'phone' => '?string',
        'address' => '?string',
        'type' => 'enum[App\Enums\ContactType]',
    ];

    protected $castHandlers = [
        'enum' => EnumCast::class
    ];
}
