<?php

namespace App\Entities;

use App\Entities\Cast\UuidCast;
use CodeIgniter\Entity\Entity;

class Category extends Entity
{
    protected $castHandlers = [
        'uuid' => UuidCast::class,
    ];
    protected $casts = [
        'id' => 'int',
        'name' => 'string',
        'business_id' => 'uuid',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
        'deleted_at'  => '?datetime'
    ];
}
