<?php

namespace App\Controllers\CRUD;

use App\Controllers\CRUDController;
use App\Entities\User;
use App\Models\UserModel;
use App\Validation\UserValidator;
use Ramsey\Uuid\Uuid;

class UserController extends CRUDController
{
    public function __construct()
    {
        parent::__construct(new UserModel(), UserValidator::class, 'user/');
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
    
    public function new() 
    {
        return view(
            'User/new',
            [
                'title' => 'Nuevo usuario'
            ]
        );
    }

    public function create() 
    {
        $this->buildValidator();
        if (!$this->validate($this->validator->create)) {
            return redirect()->back()->withInput();
        }

        $user = new User($this->request->getPost());
        $user->id = Uuid::uuid4();
        $this->model->insert($user);

        return redirect()->to($this->resourcePath);
    }

    public function update($id = null) 
    {
        $this->buildValidator();
        if (!$this->validate($this->validator->update)) {
            return redirect()->back()->withInput();
        }

        $user = new User($this->request->getPost());
        $this->model->update(uuid_to_bytes(session()->get('user_id')), $user);

        return redirect()->to($this->resourcePath.'show');
    }
    
    public function delete($id) 
    {
        $this->model->delete(uuid_to_bytes($id));
        return redirect()->to($this->resourcePath);
    }
    
    public function edit($id) {}
}
