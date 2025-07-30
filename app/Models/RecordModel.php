<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Record;

class RecordModel extends Model
{
    protected $table = 'records';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = Record::class;

    protected $allowedFields = [
        'business_id',
        'description',
        'category',
        'amount',
        'type',
        'unit_price',
        'item_id',
        'subtotal',
        'transaction_id',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    /** Busca todos los registros con sus transacción asociada
     * @return array<Record>
     */
    public function findAllByTransaction(string $transaction_id, string $businessId): array
    {
        return $this->where('business_id', uuid_to_bytes($businessId))->where('transaction_id', uuid_to_bytes($transaction_id))->orderBy('id', 'ASC')->findAll();
    }
}
