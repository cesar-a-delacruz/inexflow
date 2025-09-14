<?php

namespace App\Entities;

use App\Entities\Cast\UuidCast;
use CodeIgniter\Entity\Entity;

class Business extends Entity
{

    protected $castHandlers = ['uuid' => UuidCast::class];
    protected $casts = [
        'id' => 'uuid',
        'name' => 'string',
        'phone' => 'string',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
        'deleted_at'  => '?datetime'
    ];
}
