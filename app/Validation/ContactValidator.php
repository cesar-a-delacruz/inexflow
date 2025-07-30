<?php
namespace App\Validation;

/**
 * Son reglas de validación y mensajes de error utilizados en los formularios de App\Views\Contact
 */
class ContactValidator {
    public $create = [
        'name' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'El nombre es requerido',
            ],
        ],
        'email' => [
            'rules' => 'permit_empty|valid_email',
            'errors' => [
                'valid_email' => 'El email no es válido',
            ],
        ],
        'phone' => [
            'rules' => 'permit_empty|max_length[50]',
            'errors' => [
                'max_length' => 'El teléfono no puede exceder 50 caracteres'
            ],
        ],
        'type' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'El tipo es requerido',
            ],
        ],
    ];
    public $update = [
        'email' => [
            'rules' => 'permit_empty|valid_email',
            'errors' => [
                'valid_email' => 'El email no es válido',
            ],
        ],
        'phone' => [
            'rules' => 'permit_empty|max_length[50]',
            'errors' => [
                'max_length' => 'El teléfono no puede exceder 50 caracteres'
            ],
        ],
    ];
}