<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Record extends Entity
{
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'id' => 'integer',
        // 'business_id' => 'uuid',
        'category' => 'string',
        'description' => 'string',
        'amount' => 'integer',
        'subtotal' => 'float',
        'transaction_id' => 'uuid',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => '?datetime',
    ];

    protected $castHandlers = [
        'uuid' => Cast\UuidCast::class
    ];

    /** Muestra la cantidad del registro si tiene valor */
    public function displayAmount(): string
    {
        return $this->amount ? $this->amount : 'No Aplica';
    }

    /** Muestra el subtotal de un registro */
    public function displaySubtotal(): string
    {
        return '$' . number_format($this->subtotal, 2);
    }
}
