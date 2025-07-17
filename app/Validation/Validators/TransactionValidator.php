<?php
namespace App\Validation\Validators;

/**
 * Son reglas de validación y mensajes de error utilizados en los formularios de App\Views\Invoice en los campos "transactions"
 */
class TransactionValidator {
    public $create =  [
        'transactions' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'No hay transaccciones',
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