<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\User;
use App\Models\{UserModel, BusinessModel};
use Ramsey\Uuid\Uuid;

class UserController extends BaseController
{
    protected UserModel $model;

    public function __construct() {
        $this->model = new UserModel();
    }
    
    public function show($id = null)
    {
        $data['title'] = 'Perfil del Usuario';
        $user = $this->model->find(uuid_to_bytes($id));
        $user->business = ($user->business_id)
        ? new BusinessModel()->find($user->business_id)->business_name : 'No Aplica';
        $data['user'] = $user;
        return view('/User/show', $data);
    }
    public function update($id = null)
    {
        $user_update = (object) $this->request->getPost(['name', 'email']);
        $user = $this->model->find($id);
        $row = [];
        foreach ($user_update as $key => $value) {
            if ($value != $user->$key) $row[$key] = $value;
        }
        $this->model->update($id, $row);
        return redirect()->to("/user/$id");
    }
    public function new()
    {
        $data['title'] = 'Registrar Usuario';
        return view('/User/new', $data);
    }
    public function create()
    {
        $user_insert = (object) $this->request->getPost(['name', 'email', 'password', 'role']);
        $this->model->createUser(new User([
            'id' => Uuid::uuid3(Uuid::NAMESPACE_URL, strval(($this->model->getStats()['total'] + 1))),
            'business_id' => null,
            'name' => $user_insert->name,
            'email' => $user_insert->email,
            'password' => $user_insert->password,
            'role' => $user_insert->role,
        ]));
        return redirect()->to('user/');
    }
    public function login()
    {
        $data['title'] = 'Iniciar Sesión';
        return view('/User/login', $data);
    }
    public function index()
    {
        $data['title'] = 'Lista Usuarios';
        return view('/User/index', $data);
    }

}
