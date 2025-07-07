<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\InvoiceItem;

class InvoiceItemModel extends Model
{
    protected $table = 'invoice_items';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = InvoiceItem::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'business_id',
        'invoice_id',
        'product_id',
        'quantity',
        'unit_price',
        'line_total'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = false;
    protected $deletedField = false;

    protected $validationRules = [
        'business_id' => 'required',
        'invoice_id' => 'required',
        'product_id' => 'required',
        'quantity' => 'required|decimal|greater_than[0]',
        'unit_price' => 'required|decimal|greater_than_equal_to[0]',
        'line_total' => 'required|decimal|greater_than_equal_to[0]'
    ];

    protected $validationMessages = [
        'business_id' => [
            'required' => 'El ID del negocio es requerido'
        ],
        'invoice_id' => [
            'required' => 'El ID de la factura es requerido'
        ],
        'product_id' => [
            'required' => 'El ID del producto es requerido'
        ],
        'quantity' => [
            'required' => 'La cantidad es requerida',
            'decimal' => 'La cantidad debe ser un número decimal',
            'greater_than' => 'La cantidad debe ser mayor a 0'
        ],
        'unit_price' => [
            'required' => 'El precio unitario es requerido',
            'decimal' => 'El precio unitario debe ser un número decimal',
            'greater_than_equal_to' => 'El precio unitario debe ser mayor o igual a 0'
        ],
        'line_total' => [
            'required' => 'El total de línea es requerido',
            'decimal' => 'El total de línea debe ser un número decimal',
            'greater_than_equal_to' => 'El total de línea debe ser mayor o igual a 0'
        ]
    ];

    protected $skipValidation = false;
}
