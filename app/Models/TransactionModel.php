<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Transaction;

class TransactionModel extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = Transaction::class;

    protected $allowedFields = [
        'business_id',
        'description',
        'category',
        'amount',
        'subtotal',
        'invoice_id',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function findAllByInvoice($invoice_id): array
    {
        return $this->where('invoice_id', uuid_to_bytes($invoice_id))->orderBy('id', 'ASC')->findAll();
    }
}
