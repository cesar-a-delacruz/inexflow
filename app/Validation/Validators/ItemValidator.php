<?php
namespace App\Validation\Validators;

/**
 * Son reglas de validación y mensajes de error utilizados en los formularios de App\Views\Item
 */
class ItemValidator {
    public $create = [
        'name' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'El nombre es requerido',
            ],
        ],
        'type' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'El tipo es requerido',
            ],
        ],
        'category_id' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'La categoría es requerida',
            ],
        ],
        'cost' => [
            'rules' => 'required|greater_than_equal_to[0]',
            'errors' => [
                'required' => 'El costo es requerido',
                'greater_than_equal_to' => 'El costo debe ser mayor o igual a 0',
            ],
        ],
        'selling_price' => [
            'rules' => 'permit_empty|greater_than_equal_to[0]',
            'errors' => [
                'decimal' => 'El precio de venta debe ser un número',
                'greater_than_equal_to' => 'El precio de venta debe ser mayor o igual a 0',
            ],
        ],
        'current_stock' => [
            'rules' => 'permit_empty|integer|greater_than_equal_to[1]',
            'errors' => [
                'integer' => 'La cantidad debe ser un número entero',
                'greater_than_equal_to' => 'La cantidad debe ser mayor o igual a 1',
            ],
        ],
        'min_stock' => [
            'rules' => 'permit_empty|integer|greater_than_equal_to[0]',
            'errors' => [
                'integer' => 'La cantidad debe ser un número entero',
                'greater_than_equal_to' => 'La cantidad debe ser mayor o igual a 0',
            ],
        ],
        'measure_unit' => [
            'rules' => 'permit_empty|max_length[20]',
            'errors' => [
                'max_length' => 'La unidad de medidad no debe ser mayor a 20 caracteres',
            ],
        ],
    ];
    public $update = [
        'cost' => [
            'rules' => 'permit_empty|greater_than_equal_to[0]',
            'errors' => [
                'greater_than_equal_to' => 'El costo debe ser mayor o igual a 0',
            ],
        ],
        'selling_price' => [
            'rules' => 'permit_empty|greater_than_equal_to[0]',
            'errors' => [
                'decimal' => 'El precio de venta debe ser un número',
                'greater_than_equal_to' => 'El precio de venta debe ser mayor o igual a 0',
            ],
        ],
        'current_stock' => [
            'rules' => 'permit_empty|integer|greater_than_equal_to[1]',
            'errors' => [
                'integer' => 'La cantidad debe ser un número entero',
                'greater_than_equal_to' => 'La cantidad debe ser mayor o igual a 1',
            ],
        ],
        'min_stock' => [
            'rules' => 'permit_empty|integer|greater_than_equal_to[0]',
            'errors' => [
                'integer' => 'La cantidad debe ser un número entero',
                'greater_than_equal_to' => 'La cantidad debe ser mayor o igual a 0',
            ],
        ],
        'measure_unit' => [
            'rules' => 'permit_empty|max_length[20]',
            'errors' => [
                'max_length' => 'La unidad de medidad no debe ser mayor a 20 caracteres',
            ],
        ],
    ];
}