<?php
namespace App\Validation\Validators;

/**
 * Son reglas de validación y mensajes de error utilizados en los formularios de App\Views\User
 */
class UserValidator {
    public function loginRules() {
        return [
            'email' => [
                'rules' => 'required|valid_email|login_email|is_active',
                'errors' => [
                    'required' => 'El correo es requerido',
                    'valid_email' => 'El correo no es válido',
                    'login_email' => 'Este usuario no existe',
                    'is_active' => 'Usuario inactivo',
                ],
            ],
            'password' => [
                'rules' => 'required|login_password',
                'errors' => [
                    'required' => 'La contraseña es requerida',
                    'login_password' => 'Contraseña incorrecta',
                ],
            ]
        ];
    }
    public function indexRules() {
        return [
            'password' => [
                'rules' => 'required|delete_password[id]',
                'errors' => [
                    'required' => 'La contraseña es requerida',
                    'delete_password' => 'Contraseña incorrecta',
                ],
            ]
        ];
    }
    public function newRules() {
        return [
            'name' => [
                'rules' => 'required|max_length[50]',
                'errors' => [
                    'required' => 'El nombre es requerido',
                    'max_length' => 'El nombre no debe tener mas de 50 caracteres',
                ],
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'El correo es requerido',
                    'valid_email' => 'El correo no es válido',
                    'is_unique' => 'Ya existe un usuario con este correo',
                ],
            ],
            'password' => [
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'La contraseña es requerida',
                    'min_length' => 'La contraseña debe tener un mínimo de 8 caracteres',
                ],
            ],
            'confirm_password' => [
                'rules' => 'matches[password]',
                'errors' => [
                    'matches' => 'Las contraseñas no coinciden',
                ],
            ],
        ];
    }
    public function recoveryRules() {
        return [
            'email' => [
                'rules' => 'required|valid_email|login_email|is_active',
                'errors' => [
                    'required' => 'El correo es requerido',
                    'valid_email' => 'El correo no es válido',
                    'login_email' => 'Este usuario no existe',
                    'is_active' => 'Usuario inactivo',
                ],
            ],
        ];
    }
    public function showRules() {
        return [
            'name' => [
                'rules' => 'permit_empty|max_length[50]',
                'errors' => [
                    'max_length' => 'El nombre no debe tener mas de 50 caracteres',
                ],
            ],
            'email' => [
                'rules' => 'permit_empty|valid_email|is_unique[users.email]',
                'errors' => [
                    'valid_email' => 'El correo no es válido',
                    'is_unique' => 'Ya existe un usuario con este correo',
                ],
            ],
        ];
    }
}