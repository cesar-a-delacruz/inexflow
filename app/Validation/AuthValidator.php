<?php
namespace App\Validation;

class AuthValidator
{
    public array $login = [
        'email' => [
            'rules' => 'required|valid_email|email_exists|is_active',
            'errors' => [
                'required' => 'El correo es requerido',
                'valid_email' => 'El correo no es válido',
                'email_exists' => 'Este usuario no existe',
                'is_active' => 'Usuario inactivo',
            ],
        ],
        'password' => [
            'rules' => 'required|valid_password[]',
            'errors' => [
                'required' => 'La contraseña es requerida',
                'valid_password' => 'Contraseña incorrecta',
            ],
        ]
    ];
}