<?php
namespace App\Validation\Validators;

/**
 * Son reglas de validación y mensajes de error utilizados en los formularios de App\Views\Category
 */
class CategoryValidator {
    public $create = [
        'name' => [
            'rules' => 'required|is_unique[categories.name]',
            'errors' => [
                'required' => 'El nombre es requerido',
                'is_unique' => 'El nombre ya existe',
            ],
        ],
    ];
}