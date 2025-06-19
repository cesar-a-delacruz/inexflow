<?php
namespace App\Validation\Validators;

/**
 * Son reglas de validación y mensajes de error utilizados en los formularios de App\Views\Business
 */
class BusinessValidator {
    public function newRules() {
        return [
            'business_name' => [
                'rules' => 'required|max_length[75]',
                'errors' => [
                    'required' => 'El nombre del negocio es requerido',
                    'max_length' => 'El nombre del negocio no debe tener mas de 75 caracteres',
                ],
            ],
            'owner_name' => [
                'rules' => 'required|max_length[50]',
                'errors' => [
                    'required' => 'El nombre del dueño es requerido',
                    'max_length' => 'El nombre del dueño no debe tener mas de 50 caracteres',
                ],
            ],
            'owner_email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'El correo del dueño es requerido',
                    'valid_email' => 'El correo no es válido',
                ],
            ],
            'owner_phone' => [
                'rules' => 'required|max_length[25]',
                'errors' => [
                    'required' => 'El número de teléfono del dueño es requerido',
                    'max_length' => 'El número de teléfono no debe tener mas de 25 caracteres',
                ],
            ],
        ];
    }
    public function showRules() {
        return [
            'business_name' => [
                'rules' => 'permit_empty|max_length[75]',
                'errors' => [
                    'max_length' => 'El nombre del negocio no debe tener mas de 75 caracteres',
                ],
            ],
            'owner_name' => [
                'rules' => 'permit_empty|max_length[50]',
                'errors' => [
                    'max_length' => 'El nombre del dueño no debe tener mas de 50 caracteres',
                ],
            ],
            'owner_email' => [
                'rules' => 'permit_empty|valid_email',
                'errors' => [
                    'valid_email' => 'El correo no es válido',
                ],
            ],
            'owner_phone' => [
                'rules' => 'permit_empty|max_length[25]',
                'errors' => [
                    'max_length' => 'El nombre del dueño no debe tener mas de 25 caracteres',
                ],
            ],
        ];
    }
}