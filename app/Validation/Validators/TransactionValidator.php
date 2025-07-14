<?php
namespace App\Validation\Validators;

/**
 * Son reglas de validación y mensajes de error utilizados en los formularios de App\Views\Invoice en los campos "transactions"
 */
class TransactionValidator {
    public function newRules() {
        return [
            'transactions' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'No hay transaccciones',
                ],
            ],
            'transactions.*.amount' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'La cantidad de uno o mas items son requeridos',
                    'integer' => 'La cantidades deben ser un número entero',
                ],
            ],
            'transactions.*.subtotal' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Uno o mas subtotales están vacíos',
                ],
            ],
        ];
    }
}