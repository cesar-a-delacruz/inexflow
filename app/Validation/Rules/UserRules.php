<?php
namespace App\Validation\Rules;

use App\Entities\User;
use App\Models\UserModel;

/**
 * Son las reglas presonalizadas de validación utilizadas en los formularios de App\Views\User 
 */
class UserRules {
    protected UserModel $model;
    protected ?User $user;
    public function __construct() {
        $this->model = new UserModel();
        $this->user = null;
    }

    public function login_email($email) {
        $found_user = $this->model->findByEmail($email);
        if ($found_user instanceof User) {
            $this->user = $found_user;
            return true;
        } 
        
        return false;
    }
    public function is_active() {
        return $this->user->is_active;
    }
    public function login_password($password) {
        if (!$this->user) return false;
        return $this->user->verifyPassword($password);
    }
    
    public function delete_password($password, $fields, $data) {
        $this->user = $this->model->find(uuid_to_bytes($data['id']));
        return $this->user->verifyPassword($password);
    }
}