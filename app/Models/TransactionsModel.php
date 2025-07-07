<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Transaction;
use CodeIgniter\Database\Exceptions\DatabaseException;

class TransactionsModel extends Model
{
    protected $table            = 'transactions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Transaction::class;

    protected $allowedFields    = [
        'business_id',
        'category_number',
        'amount',
        'description',
        'transaction_date',
        'payment_method',
        'notes',
        'invoice_id',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        // 'business_id'      => 'permit_empty|integer',
        'category_number'  => 'permit_empty|integer',
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

    public function createTransaction(Transaction $transaction, $returnID = true): bool|int
    {
        try {

            $result = $this->insert($transaction);

            if ($result === false) {
                throw new DatabaseException('Error al insertar la transacción: ' . implode(', ', $this->errors()));
            }
            if ($returnID) return $returnID;

            return $result;
        } catch (\Exception $e) {
            log_message('error', 'Error creando transacción: ' . $e->getMessage());
            throw $e;
        }
    }
    public function findAllWithCategory()
    {
        $builder = $this->builder();
        $result = $builder->select('id, categories.name as category_name, amount, description, transaction_date, payment_method, notes')
            ->join('categories', 'categories.category_number = transactions.category_number')->orderBy('id', 'ASC');
        $transaction = $result->get()->getCustomResultObject(\App\Entities\Transaction::class);
        $result->get()->freeResult();
        return $transaction;
    }
}
