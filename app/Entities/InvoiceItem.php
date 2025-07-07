<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class InvoiceItem extends Entity
{
    protected $datamap = [];

    protected $dates = ['created_at'];

    protected $casts = [
        'id' => 'int',
        'business_id' => 'uuid',
        'invoice_id' => 'uuid',
        'product_id' => 'uuid',
        'quantity' => 'decimal',
        'unit_price' => 'decimal',
        'line_total' => 'decimal',
        'created_at' => 'datetime',
    ];

    protected $attributes = [
        'id' => null,
        'business_id' => null,
        'invoice_id' => null,
        'product_id' => null,
        'quantity' => null,
        'unit_price' => null,
        'line_total' => null,
    ];

    protected $castHandlers = [
        'uuid' => Cast\UuidCast::class
    ];
}
