<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Transaction extends Entity
{
    protected $attributes = [
        'id' => null,
        'business_id'        => null,
        'category_number'    => null,
        'amount'             => null,
        'description'        => null,
        'transaction_date'   => null,
        'payment_method'     => 'cash',
        'notes'              => null,
        'created_at'         => null,
        'updated_at'         => null,
        'deleted_at'         => null,
        'category_name'      => null,
    ];

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    protected $casts = [
        'id'                 => 'integer',
        'business_id'        => 'uuid',
        'category_number'    => 'integer',
        'amount'             => 'float',
        'description'        => 'string',
        'transaction_date'   => 'string',
        'payment_method'     => 'string',
        'notes'              => '?string',
        'created_at'         => 'datetime',
        'updated_at'         => 'datetime',
        'deleted_at'         => '?datetime',
        'category_name'      => 'string',
    ];

    protected $castHandlers = [
        'uuid' => Cast\UuidCast::class
    ];

    public function getMethodDisplayName(): string
    {
        return match ($this->payment_method) {
            'cash' => 'Efectivo',
            'card' => 'Tarjeta de Débito/Crédito',
            'transfer' => 'Transferencia Bancaria',
        };
    }
}