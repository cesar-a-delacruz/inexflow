<?php

namespace App\Validation\Rules;

use App\Entities\User;
use App\Models\UserModel;

/**
 * Son las reglas presonalizadas de validación utilizadas en los formularios de App\Views\User 
 */
class UserRules
{
    protected $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    /** Verifica que el correo es único en la base de datos sin contar el del usuario actual  */
    public function unique_email(string $email)
    {
        return !$this->model->emailUnique($email, session()->get('user_id'));
    }
}
