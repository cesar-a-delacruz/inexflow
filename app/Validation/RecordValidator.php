<?php
namespace App\Validation;

/**
 * Son reglas de validación y mensajes de error utilizados en los formularios de App\Views\Transaction en los campos "records"
 */
class RecordValidator {
    public $create = [
        'records' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'No hay registros',
            ],
        ],
        'records.*.subtotal' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Uno o mas subtotales están vacíos',
            ],
        ],
    ];
}