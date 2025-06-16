<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Transaction extends Entity
{
    protected $attributes = [
        'transaction_number' => null,
        'business_id'        => null,
        'category_id'        => null,
        'amount'             => null,
        'description'        => null,
        'transaction_date'   => null,
        'payment_method'     => 'cash',
        'notes'              => null,
        'created_at'         => null,
        'updated_at'         => null,
        'deleted_at'         => null,
    ];

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    protected $casts = [
        'transaction_number' => 'integer',
        'business_id'        => 'uuid',
        'category_id'        => 'integer',
        'amount'             => 'float',
        'description'        => 'string',
        'transaction_date'   => 'date',
        'payment_method'     => 'string',
        'notes'              => '?string',
        'created_at'         => 'datetime',
        'updated_at'         => 'datetime',
        'deleted_at'         => '?datetime',
    ];

    protected $castHandlers = [
        'uuid' => Cast\UuidCast::class
    ];
}