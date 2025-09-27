<?php

namespace App\Models;

use App\Entities\Payment;
use App\Models\EntityModel;

/**
 * @extends EntityModel<Payment>
 */
class PaymentsModel extends EntityModel
{
    protected $table = 'payments';
    protected $returnType = Payment::class;

    protected $allowedFields = [
        'id',
        'business_id',
        'transaction_id',
        'payment_method',
        'amount',
    ];
}
