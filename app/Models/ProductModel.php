<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Product;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false;
    protected $returnType = Product::class;
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'id',
        'business_id',
        'category_number',
        'name',
        'description',
        'sku',
        'cost_price',
        'selling_price',
        'is_service',
        'track_inventory',
        'current_stock',
        'min_stock_level',
        'unit_of_measure',
        'is_active'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [
        'business_id' => 'required',
        'name' => 'required|max_length[255]',
        'sku' => 'permit_empty|max_length[100]',
        'cost_price' => 'required|decimal',
        'selling_price' => 'required|decimal',
        'is_service' => 'required|in_list[0,1]',
        'track_inventory' => 'required|in_list[0,1]',
        'current_stock' => 'required|integer',
        'min_stock_level' => 'required|integer',
        'unit_of_measure' => 'required|max_length[20]',
        'is_active' => 'required|in_list[0,1]'
    ];

    protected $validationMessages = [
        'business_id' => [
            'required' => 'El ID del negocio es requerido'
        ],
        'name' => [
            'required' => 'El nombre del producto es requerido',
            'max_length' => 'El nombre no puede exceder 255 caracteres'
        ],
        'sku' => [
            'max_length' => 'El código SKU no puede exceder 100 caracteres'
        ],
        'cost_price' => [
            'required' => 'El precio de costo es requerido',
            'decimal' => 'El precio de costo debe ser un número decimal'
        ],
        'selling_price' => [
            'required' => 'El precio de venta es requerido',
            'decimal' => 'El precio de venta debe ser un número decimal'
        ],
        'is_service' => [
            'required' => 'Debe indicar si es servicio',
            'in_list' => 'El campo servicio debe ser 0 o 1'
        ],
        'track_inventory' => [
            'required' => 'Debe indicar si controla inventario',
            'in_list' => 'El campo inventario debe ser 0 o 1'
        ],
        'current_stock' => [
            'required' => 'El stock actual es requerido',
            'integer' => 'El stock debe ser un número entero'
        ],
        'min_stock_level' => [
            'required' => 'El stock mínimo es requerido',
            'integer' => 'El stock mínimo debe ser un número entero'
        ],
        'unit_of_measure' => [
            'required' => 'La unidad de medida es requerida',
            'max_length' => 'La unidad de medida no puede exceder 20 caracteres'
        ],
        'is_active' => [
            'required' => 'El estado es requerido',
            'in_list' => 'El estado debe ser 0 o 1'
        ]
    ];

    protected $skipValidation = false;
}
