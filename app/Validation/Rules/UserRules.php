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

    public function email_exists($email) 
    {
        $user = $this->model->findByEmail($email);
        if ($user) {
            $this->user = $user;
            return true;
        } 
        return false;
    }

    public function is_active()
    {
        return $this->user->is_active;
    }
    
    public function valid_password($password, $fields, $data) {
        if ($fields === '') return $this->user->verifyPassword($password);
        else {
            $user = $this->model->find(uuid_to_bytes($data['id']));
            return $user->verifyPassword($password);
        }
    }

    public function unique_email($email) 
    {
        return !$this->model->emailUnique($email, uuid_to_bytes(session()->get('id')));
    }
}