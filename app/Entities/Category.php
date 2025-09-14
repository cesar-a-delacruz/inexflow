<?php

namespace App\Entities;

use App\Entities\AuditableEntity;

class Category extends AuditableEntity
{
    protected $tenant = true;
    protected $casts = [
        'id' => 'int',
        'name' => 'string',
    ];
}
