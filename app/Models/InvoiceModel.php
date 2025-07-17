<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Invoice;

class InvoiceModel extends Model
{
    protected $table = 'invoices';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false;
    protected $returnType = Invoice::class;
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

    public function findAllWithContact($business_id): array 
    {
        return $this->select('invoices.*, contacts.name as contact_name, contacts.type as contact_type')
        ->where('invoices.business_id', uuid_to_bytes($business_id))->join('contacts', 'contacts.id = invoices.contact_id', 'left')->findAll();
    }
}
