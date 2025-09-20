<?php

namespace App\Entities;

use App\Entities\Cast\EnumCast;
use App\Entities\Cast\UuidCast;
use CodeIgniter\Entity\Entity;

class Transaction extends Entity
{

    protected $castHandlers = [
        'enum' => EnumCast::class,
        'uuid' => UuidCast::class
    ];
    protected $casts = [
        'id' => 'int',
        'number' => 'string',
        'contact_id' => '?int',
        'payment_status' => 'enum[App\Enums\PaymentStatus]',
        'description' => '?string',
        'total' => 'float',
        'type' => 'enum[App\Enums\TransactionType]',
        'due_date' => '?datetime',
        'business_id' => 'uuid',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
        'deleted_at'  => '?datetime'
    ];
    public function displayTotal(): string
    {
        return number_to_currency($this->total, 'PAB', 'es_PA', 2);
    }
}
