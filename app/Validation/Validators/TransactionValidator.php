<?php
namespace App\Validation\Validators;

/**
 * Son reglas de validación y mensajes de error utilizados en los formularios de App\Views\Transaction
 */
class TransactionValidator {
    public function newRules() {
        return [
            'description' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'la descripción es requerida',
                ],
            ],
            'category_number' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'El número de categoría es requerido',
                    'integer' => 'El número de ser entero',
                ],
            ],
            'amount' => [
                'rules' => 'required|decimal',
                'errors' => [
                    'required' => 'El número de categoría es requerido',
                    'decimal' => 'El número debe ser decimal',
                ],
            ],
        ];
    }
    public function showRules() {
        return [
            'category_number' => [
                'rules' => 'permit_empty|integer',
                'errors' => [
                    'integer' => 'El número de ser entero',
                ],
            ],
            'amount' => [
                'rules' => 'permit_empty|decimal',
                'errors' => [
                    'decimal' => 'El número debe ser decimal',
                ],
            ],
        ];
    }
}