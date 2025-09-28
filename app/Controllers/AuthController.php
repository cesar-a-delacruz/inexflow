<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Enums\UserRole;
use App\Models\BusinessModel;
use App\Models\UserModel;
use App\Validation\AuthValidator;

class AuthController extends BaseController
{
    protected $model;
    protected $businessModel;
    protected $formValidator;

    public function __construct()
    {
        $this->model = new UserModel();
        $this->businessModel = new BusinessModel();
        $this->formValidator = new AuthValidator();
    }

    public function login()
    {
        return view('/auth/login', ['title' => 'Iniciar Sesión']);
    }

    public function verify()
    {
        if (!$this->validate($this->formValidator->login)) {
            return redirect()->back()->withInput();
        }

        $post = $this->request->getPost();
        $user = $this->model->findByEmail($post['email']);

        $init_page = match ($user->role) {
            UserRole::Admin => '/user',
            UserRole::Businessman => '/tenants'
        };

        session()->set([
            'user_id' => $user->id->toString(),
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_role' => $user->role->value,
            'business_id' => $user->business_id ? $user->business_id->toString() : null
        ]);

        return redirect()->to($init_page);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login');
    }
}
