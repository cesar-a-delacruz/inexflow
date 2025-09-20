<?php

namespace App\Models;

use App\Entities\Transaction;
use App\Enums\TransactionType;
use App\Models\EntityModel;

/**
 * @extends EntityModel<Transaction>
 */
class TransactionModel extends EntityModel
{
    protected $table = 'transactions';
    protected $returnType = Transaction::class;

    protected $allowedFields = [
        'id',
        'business_id',
        'number',
        'contact_id',
        'payment_status',
        'description',
        'due_date',
        'total',
    ];

    /** Busca todos las transacciones con su contacto asociado por su negocio
     * @return array<Transaction>
     */
    public function findAllWithContact(string $business_id): array
    {
        return $this
            ->select('transactions.*, c.name as contact_name, c.type as contact_type')
            ->where('transactions.business_id', uuid_to_bytes($business_id))
            ->join('contacts c', 'c.business_id = transactions.business_id AND c.id = transactions.contact_id', 'left')
            ->findAll();
    }
    /** 
     * @return array<Transaction>
     */
    public function findAllByBusinessIdAndType(string $businessId, TransactionType $type): array
    {
        return $this
            ->where('business_id', uuid_to_bytes($businessId))
            ->where('type', $type->value)
            ->findAll();
    }
}
