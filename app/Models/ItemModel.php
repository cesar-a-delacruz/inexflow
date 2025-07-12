<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Item;

class ItemModel extends Model
{
    protected $table = 'items';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false;
    protected $returnType = Item::class;
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'id',
        'business_id',
        'category_number',
        'name',
        'type',
        'cost',
        'selling_price',
        'current_stock',
        'min_stock',
        'measure_unit',
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
        'type' => 'required|in_list[product,service]',
        'cost' => 'required|decimal',
        'selling_price' => 'permit_empty|decimal',
        'current_stock' => 'permit_empty|integer',
        'min_stock' => 'permit_empty|integer',
        'measure_unit' => 'permit_empty|max_length[20]',
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
        'type' => [
            'required' => 'El campo tipo es requerido',
            'in_list' => 'Debe indicar si es servicio o producto'
        ],
        'cost' => [
            'required' => 'El costo es requerido',
            'decimal' => 'El precio de costo debe ser un número decimal'
        ],
        'selling_price' => [
            'decimal' => 'El precio de venta debe ser un número decimal'
        ],
        'current_stock' => [
            'integer' => 'El stock debe ser un número entero'
        ],
        'min_stock' => [
            'integer' => 'El stock mínimo debe ser un número entero'
        ],
        'measure_unit' => [
            'max_length' => 'La unidad de medida no puede exceder 20 caracteres'
        ],
    ];

    protected $skipValidation = false;

    public function findAllWithCategory()
    {
        $builder = $this->builder();
        $result = $builder->select('categories.name as category_name, items.*')
            ->join('categories', 'categories.category_number = items.category_number')->orderBy('id', 'ASC');
        $transaction = $result->get()->getCustomResultObject($this->returnType);
        $result->get()->freeResult();
        return $transaction;
    }
}
