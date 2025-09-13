<?php

namespace App\Models;

use App\Models\AuditableModel;
use App\Entities\Record;

class RecordModel extends AuditableModel
{
    protected $table = 'records';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = Record::class;

    protected $allowedFields = [
        'id',
        'business_id',
        'product_id',
        'transaction_id',
        'unit_price',
        'quantity',
        'subtotal',
    ];

    /** Busca todos los registros con sus transacción asociada
     * @return array<Record>
     */
    public function findAllByTransaction(string $transaction_id, string $businessId): array
    {
        return $this->where('business_id', uuid_to_bytes($businessId))->where('transaction_id', uuid_to_bytes($transaction_id))->orderBy('id', 'ASC')->findAll();
    }
}
