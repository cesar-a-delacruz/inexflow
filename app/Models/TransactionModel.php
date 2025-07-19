<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Transaction;

class TransactionModel extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false;
    protected $returnType = Transaction::class;
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'id',
        'business_id',
        'contact_id',
        'number',
        'due_date',
        'payment_status',
        'payment_method',
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    /** Busca todos las transacciones con su contacto asociado por su negocio
     * @return array<Transaction>
    */
    public function findAllWithContact(string $business_id): array 
    {
        return $this->select('transactions.*, contacts.name as contact_name, contacts.type as contact_type')
        ->where('transactions.business_id', uuid_to_bytes($business_id))->
        join('contacts', 'contacts.id = transactions.contact_id', 'left')->findAll();
    }
}
