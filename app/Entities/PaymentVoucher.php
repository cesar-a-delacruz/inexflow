<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class PaymentVoucher extends Entity
{
    protected $datamap = [];

    protected $dates = ['payment_date', 'created_at'];

    protected $casts = [
        'id' => 'uuid',
        'business_id' => 'uuid',
        'contact_id' => 'uuid',
        'account_payable_id' => '?uuid',
        'amount' => 'decimal',
        'payment_method' => 'string',
        'payment_date' => 'datetime',
        'reference' => '?string',
        'notes' => '?string',
        'created_by' => 'uuid',
        'created_at' => 'datetime',
    ];

    protected $attributes = [
        'id' => null,
        'business_id' => null,
        'contact_id' => null,
        'account_payable_id' => null,
        'amount' => null,
        'payment_method' => null,
        'payment_date' => null,
        'reference' => null,
        'notes' => null,
        'created_by' => null,
    ];

    protected $castHandlers = [
        'uuid' => Cast\UuidCast::class
    ];
}
