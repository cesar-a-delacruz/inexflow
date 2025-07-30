<?php

namespace App\Validation;

/**
 * Son reglas de validación y mensajes de error utilizados en los formularios de App\Views\Transaction en los campos "records"
 */
class RecordValidator
{
    public $create = [
        'records' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'No hay registros',
            ],
        ],
        'records.*.amount' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Uno o mas cantidades están vacíos',
            ],
        ],
        'records.*.item_id' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'El id del producto es obligatorio',
            ],
        ],
        'records.*.category' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Uno o mas categorias están vacíos',
            ],
        ],
    ];
}
