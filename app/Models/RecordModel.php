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
        'subtotal',
        'transaction_id',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    public function findAllByTransaction($invoice_id): array
    {
        return $this->where('transaction_id', uuid_to_bytes($invoice_id))->orderBy('id', 'ASC')->findAll();
    }
}
