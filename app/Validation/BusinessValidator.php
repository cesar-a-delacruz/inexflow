<?php

namespace App\Validation;

/**
 * Son reglas de validación y mensajes de error utilizados en los formularios de App\Views\Business
 */
class BusinessValidator {
    public $create = [
        'name' => [
            'rules' => 'required|max_length[75]',
            'errors' => [
                'required' => 'El nombre del negocio es requerido',
                'max_length' => 'El nombre del negocio no debe tener mas de 75 caracteres',
            ],
        ],
        'phone' => [
            'rules' => 'required|max_length[25]',
            'errors' => [
                'required' => 'El número de teléfono del dueño es requerido',
                'max_length' => 'El número de teléfono no debe tener mas de 25 caracteres',
            ],
        ],
    ];
    public $update = [
        'name' => [
            'rules' => 'permit_empty|max_length[75]',
            'errors' => [
                'max_length' => 'El nombre del negocio no debe tener mas de 75 caracteres',
            ],
        ],
        'phone' => [
            'rules' => 'permit_empty|max_length[25]',
            'errors' => [
                'max_length' => 'El nombre del dueño no debe tener mas de 25 caracteres',
            ],
        ],
    ];
}