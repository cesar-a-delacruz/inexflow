<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Invoice extends Entity
{
    protected $datamap = [];

    protected $dates = ['invoice_date', 'due_date', 'created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'id' => 'uuid',
        'business_id' => 'uuid',
        'contact_id' => 'uuid',
        'invoice_number' => 'string',
        'invoice_date' => 'datetime',
        'due_date' => '?datetime',
        'subtotal' => 'decimal',
        'tax_amount' => 'decimal',
        'discount_amount' => 'decimal',
        'total_amount' => 'decimal',
        'payment_status' => 'string',
        'payment_method' => 'string',
        'notes' => 'string',
        'created_by' => 'uuid',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => '?datetime',
    ];

    protected $attributes = [
        'id' => null,
        'business_id' => null,
        'contact_id' => null,
        'invoice_number' => null,
        'invoice_date' => null,
        'due_date' => null,
        'subtotal' => null,
        'tax_amount' => 0.00,
        'discount_amount' => 0.00,
        'total_amount' => null,
        'payment_status' => 'paid',
        'payment_method' => null,
        'notes' => null,
        'created_by' => null,
    ];

    protected $castHandlers = [
        'uuid' => Cast\UuidCast::class
    ];
}
