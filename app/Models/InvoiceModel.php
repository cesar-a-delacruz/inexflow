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
        'invoice_number',
        'invoice_date',
        'due_date',
        'payment_status',
        'payment_method',
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [
        'business_id' => 'required',
        'invoice_number' => 'required|max_length[50]',
        'invoice_date' => 'required|valid_date',
        'due_date' => 'permit_empty|valid_date',
        'payment_status' => 'required|in_list[paid,pending,overdue,cancelled]',
        'payment_method' => 'permit_empty|in_list[cash,card,transfer,credit,mixed]',
    ];

    protected $validationMessages = [
        'business_id' => [
            'required' => 'El ID del negocio es requerido'
        ],
        'invoice_number' => [
            'required' => 'El número de factura es requerido',
            'max_length' => 'El número de factura no puede exceder 50 caracteres'
        ],
        'invoice_date' => [
            'required' => 'La fecha de factura es requerida',
            'valid_date' => 'La fecha de factura debe ser válida'
        ],
        'due_date' => [
            'valid_date' => 'La fecha de vencimiento debe ser válida'
        ],
        'payment_status' => [
            'required' => 'El estado de pago es requerido',
            'in_list' => 'El estado de pago debe ser: paid, pending, overdue, cancelled'
        ],
        'payment_method' => [
            'in_list' => 'El método de pago debe ser: cash, card, transfer, credit, mixed'
        ],
    ];

    protected $skipValidation = false;
}
