<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Transaction extends Entity
{
    protected $attributes = [
        'id' => null,
        'description'        => null,
        'category'        => null,
        'amount'             => null,
        'total'             => null,
        'discount'             => null,
        'invoice_id'         => null,
        'created_at'         => null,
        'updated_at'         => null,
        'deleted_at'         => null,
    ];

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    protected $casts = [
        'id'                 => 'integer',
        'business_id'        => 'uuid',
        'category'    => 'string',
        'description'        => 'string',
        'amount'             => 'integer',
        'subtotal'             => 'float',
        'invoice_id'         => 'uuid',
        'created_at'         => 'datetime',
        'updated_at'         => 'datetime',
        'deleted_at'         => '?datetime',
    ];

    protected $castHandlers = [
        'uuid' => Cast\UuidCast::class
    ];
}
