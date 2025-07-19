<?php
namespace App\Validation\Rules;

use App\Entities\User;
use App\Models\UserModel;

/**
 * Son las reglas presonalizadas de validación utilizadas en los formularios de App\Views\User 
 */
class UserRules {
    protected $model;
    protected ?User $user;

    public function __construct() 
    {
        $this->model = new UserModel();
        $this->user = null;
    }

    /** Verifica si el correo (usuario) existe en la base de datos */
    public function email_exists(string $email) 
    {
        $user = $this->model->findByEmail($email);
        if ($user) {
            $this->user = $user;
            return true;
        } 
        return false;
    }

    /** Verifica si el usuario está activo */
    public function is_active()
    {
        return $this->user->is_active;
    }
    
    /** Verifica si la contraseña coincide con el usuario.
     * Si se le pasa el id, busca el usuario para verificarlo, de lo contrario verifica con el
     * que tienen actualmente. Se usa para incio de seción y eliminación de usuario.
     */
    public function valid_password(string $password, string $fields, array $data) {
        if ($fields === '') return $this->user->verifyPassword($password);
        else {
            $user = $this->model->find(uuid_to_bytes($data['id']));
            return $user->verifyPassword($password);
        }
    }
    /** Verifica que el correo es único en la base de datos sin contar el del usuario actual  */
    public function unique_email(string $email) 
    {
        return !$this->model->emailUnique($email, session()->get('id'));
    }
}