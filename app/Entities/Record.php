<?php

namespace App\Entities;

use App\Entities\AuditableEntity;

class Record extends AuditableEntity
{
    protected $tenant = true;

    protected $casts = [
        'id' => 'int',
        'product_id' => 'int',
        'transaction_id' => 'int',
        'unit_price' => 'float',
        'quantity' => 'int',
        'subtotal' => 'float',
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
