<?php
namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;
use App\Entities\Transaction;

class TransactionsModel extends Model
{
    protected $table            = 'transactions';
    protected $primaryKey       = 'transaction_number';
    protected $useAutoIncrement = true;
    protected $returnType       = Transaction::class;

     protected $allowedFields    = [
        'business_id',
        'category_id',
        'amount',
        'description',
        'transaction_date',
        'payment_method',
        'notes',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    // protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

     protected $validationRules = [
        'business_id'      => 'permit_empty|integer',
        'category_id'      => 'permit_empty|integer',
        'amount'           => 'required|decimal',
        'transaction_date' => 'required|valid_date',
        'payment_method'   => 'required|in_list[cash,card,transfer]',
    ];

    protected $validationMessages = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}