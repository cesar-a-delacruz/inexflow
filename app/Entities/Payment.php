<?php

namespace App\Entities;

use App\Entities\Cast\EnumCast;
use App\Entities\Cast\UuidCast;
use CodeIgniter\Entity\Entity;

class Payment extends Entity
{

    protected $castHandlers = [
        'enum' => EnumCast::class,
        'uuid' => UuidCast::class,
    ];
    protected $casts = [
        'id' => 'int',
        'transaction_id' => 'int',
        'payment_method' => 'enum[App\Enums\PaymentMethod]',
        'amount' => 'float',
        'business_id' => 'uuid',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
        'deleted_at'  => '?datetime'
    ];
}
