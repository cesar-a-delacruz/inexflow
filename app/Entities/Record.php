<?php

namespace App\Entities;

use App\Entities\Cast\UuidCast;
use CodeIgniter\Entity\Entity;

class Record extends Entity
{
    protected $castHandlers = [
        'uuid' => UuidCast::class,
    ];

    protected $casts = [
        'id' => 'int',
        'product_id' => 'int',
        'transaction_id' => 'int',
        'unit_price' => 'float',
        'quantity' => 'int',
        'subtotal' => 'float',
        'business_id' => 'uuid',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
        'deleted_at'  => '?datetime'
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
