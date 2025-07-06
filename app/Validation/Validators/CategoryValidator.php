<?php
namespace App\Validation\Validators;

/**
 * Son reglas de validación y mensajes de error utilizados en los formularios de App\Views\Category
 */
class CategoryValidator {
    public function newRules() {
        return [
            'category_number' => [
                'rules' => 'required|integer|is_unique[categories.category_number]',
                'errors' => [
                    'required' => 'El número de categoría es requerido',
                    'integer' => 'El número de ser entero',
                    'is_unique' => 'El número de categoría ya existe',
                ],
            ],
            'name' => [
                'rules' => 'required|is_unique[categories.name]',
                'errors' => [
                    'required' => 'El nombre es requerido',
                    'is_unique' => 'El nombre ya existe',
                ],
            ],
        ];
    }
}