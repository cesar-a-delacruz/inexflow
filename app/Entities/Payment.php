<?php

namespace App\Entities;

use App\Entities\AuditableEntity;
use App\Entities\Cast\EnumCast;

class Payment extends AuditableEntity
{
    protected $tenant = true;

    protected $casts = [
        'id' => 'int',
        'transaction_id' => 'int',
        'payment_method' => 'enum[App\Enums\PaymentMethod]',
        'amount' => 'float',
    ];
    protected $castHandlers = [
        'enum' => EnumCast::class,
    ];
}
