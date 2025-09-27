<?php

namespace App\Validation;

use App\Entities\Service;

/**
 * @extends CRUDValidator<Service>
 */
class ServiceValidator extends CRUDValidator
{
    public array $create = [
        'name' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'El nombre es requerido',
            ],
        ],
        'cost' => [
            'rules' => 'required|decimal|greater_than_equal_to[0]',
            'errors' => [
                'required' => 'El costo es requerido',
                'decimal' => 'El costo de venta debe ser un número',
                'greater_than_equal_to' => 'El costo debe ser mayor o igual a 0',
            ],
        ],
        'selling_price' => [
            'rules' => 'permit_empty|decimal|greater_than_equal_to[0]',
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
            'rules' => 'permit_empty|integer|greater_than_equal_to[1]',
            'errors' => [
                'integer' => 'La cantidad debe ser un número entero',
                'greater_than_equal_to' => 'La cantidad debe ser mayor o igual a 1',
            ],
        ],
        'measure_unit_id' => [
            'rules' => 'integer|greater_than_equal_to[1]',
            'errors' => [
                'integer' => 'La unidad de medida es incorrecta',
                'greater_than_equal_to' => 'El id de la unidad de medida debe ser mayor o igual a 1',
            ],
        ],
    ];
    public array $update = [
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
            'rules' => '|max_length[20]',
            'errors' => [
                'max_length' => 'La unidad de medidad no debe ser mayor a 20 caracteres',
            ],
        ],
    ];
}
