<?php

namespace App\Validation;

/**
 * Son reglas de validación y mensajes de error utilizados en los formularios de App\Views\Category
 * @extends CRUDValidator<Category>
 */
class CategoryValidator extends CRUDValidator
{
    public $create = [
        'name' => [
            'rules' => 'required|unique_in_business',
            'errors' => [
                'required' => 'El nombre es requerido',
                'unique_in_business' => 'El nombre ya existe',
            ],
        ],
    ];
    public $update = [
        'name' => [
            'rules' => 'permit_empty|unique_in_business',
            'errors' => [
                'unique_in_business' => 'El nombre ya existe',
            ],
        ],
    ];
}
