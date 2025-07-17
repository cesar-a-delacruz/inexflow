<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Transaction extends Entity
{
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    protected $casts = [
        'id' => 'integer',
        'business_id' => 'uuid',
        'category' => 'string',
        'description' => 'string',
        'amount' => 'integer',
        'subtotal' => 'float',
        'invoice_id' => 'uuid',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => '?datetime',
    ];

    protected $castHandlers = [
        'uuid' => Cast\UuidCast::class
    ];

    public function displayAmount(): string
    {
        return $this->amount ? $this->amount : 'No Aplica';
    }
    public function displaySubtotal(): string
    {
        return $this->subtotal ? '$'.number_format($this->subtotal, 2) : 'No Aplica';
    }
}
