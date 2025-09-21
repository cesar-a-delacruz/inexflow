<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Enums\UserRole;
use App\Models\BusinessModel;
use App\Models\UserModel;
use App\Validation\UserValidator;

class AuthController extends BaseController
{
    protected $model;
    protected $businessModel;
    protected $formValidator;

    public function __construct()
    {
        $this->model = new UserModel();
        $this->businessModel = new BusinessModel();
        $this->formValidator = new UserValidator();
    }

    public function index()
    {
        return view('/home');
    }

    public function login()
    {
        return view('/auth/login', ['title' => 'Login']);
    }

    public function attemptLogin()
    {
        if (!$this->validate($this->formValidator->login)) {
            return redirect()->back()->withInput();
        }

        $post = $this->request->getPost();
        $user = $this->model->findByEmail($post['email']);

        $init_page = match ($user->role) {
            UserRole::Admin => '/admin',
            UserRole::Businessman => '/tenants'
        };

        session()->set([
            'user_id' => $user->id->toString(),
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_role' => $user->role->value,
            'business_id' => $user->business_id->toString(),
            'current_page' => $init_page
        ]);

        return redirect()->to($init_page);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
