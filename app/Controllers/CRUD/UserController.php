<?php

namespace App\Controllers\CRUD;

use App\Controllers\CRUDController;
use App\Models\UserModel;
use App\Validation\UserValidator;

class UserController extends CRUDController
{
    public function __construct()
    {
        parent::__construct(new UserModel(), UserValidator::class, 'user');
    }

    public function index()
    {
        return view(
            'User/index',
            [
                'title' => 'Usuarios',
                'users' => $this->model->findAll()
            ]
        );
    }
    
    public function show($id = null) 
    {
        return view(
            'User/show',
            [
                'title' => 'Perfil',
                'user' => $this->model->find(uuid_to_bytes(session()->get('user_id')))
            ]
        );
    }
    
    public function new() {}
    public function create() {}
    public function edit($id) {}
    public function update($id) {}
    public function delete($id) {}
}
