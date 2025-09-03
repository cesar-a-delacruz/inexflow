<?php

namespace App\Validation;

/**
 * Son reglas de validación y mensajes de error utilizados en los formularios de App\Views\Transaction
 */
class TransactionValidator
{
    public $create = [
        'due_date' => [
            'rules' => 'required|valid_date[Y-m-d]',
            'errors' => [
                'required' => 'La fecha de vencimiento es requerida',
                'valid_date' => 'La fecha no es válida',
            ],
        ],
        'payment_status' => [
            'rules' => 'required|in_list[paid,pending,cancelled,overdue]',
            'errors' => [
                'required' => 'El estado de la transacción es requerido',
                'in_list' => 'El estado de la transfenecia es invalido'
            ],
        ],
        'payment_method' => [
            'rules' => 'required|in_list[card,cash,transfer]',
            'errors' => [
                'required' => 'El método de pago es requerido',
                'in_list' => 'El metodo de pago debe ser: transferencias, Efectivo o Banco'
            ],
        ],
        'type' => [
            'rules' => 'required|in_list[income,expense]',
            'errors' => [
                'required' => 'El tipo de pago es requerido',
                'in_list' => 'El tipo de pago es invalido'
            ],
        ]
    ];
    public $update = [
        'due_date' => [
            'rules' => 'permit_empty|valid_date[Y-m-d]',
            'errors' => [
                'valid_date' => 'La fecha no es válida',
            ],
        ],
    ];
}
