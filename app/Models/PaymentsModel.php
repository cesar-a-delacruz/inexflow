<?php

namespace App\Models;

use App\Models\AuditableModel;
use App\Entities\Payment;

class PaymentsModel extends AuditableModel
{
    protected $table = 'payments';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = Payment::class;

    protected $allowedFields = [
        'id',
        'business_id',
        'transaction_id',
        'payment_method',
        'amount',
    ];
}
