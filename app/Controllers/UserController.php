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
        ? new BusinessModel()->find(uuid_to_bytes($user->business_id))->business_name : 'NULO';
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
    public function verify()
    {
        $post = (object) $this->request->getPost(['email', 'password']);
        $user = $this->model->findByEmail($post->email);
        
        $is_invalid = $this->validateUser($user, $post);
        if ($is_invalid !== false) return $is_invalid;

        session()->set([
            'id'         => $user->getIdAsString(),
            'name'       => $user->name,
            'email'      => $user->email,
            'role'       => $user->role
        ]);
        
        return match ($user->role) {
            'admin' => redirect()->to('/user'),
            'businessman' => $user->getBusinessIdAsString() ?
                redirect()->to('/user/'.$user->getIdAsString().'/business') : 
                redirect()->to('/user/'.$user->getIdAsString())
        };
        
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
    public function index()
    {
        $data['title'] = 'Lista de Usuarios';
        $data['users'] = $this->model->findAll();
        return view('/User/index', $data);
    }
    public function delete($id = null)
    {
        $business_model = new BusinessModel();
        $business = $business_model->getBusinessesByUser($id)[0];
        $business_model->deleteBusiness($business->id);
        $this->model->delete(uuid_to_bytes($id));
        return redirect()->to('user/');
    }
    private function validateUser($user, $post) {
        if (!$user) {
            return redirect()->back()->with('error', 'Usuario no encontrado.');
        } else if (!$user->verifyPassword($post->password)) {
            return redirect()->back()->with('error', 'Contraseña incorrecta.');
        } else if (!$user->isActive()) {
            return redirect()->back()->with('error', 'Cuenta inactiva. Contacte al administrador.');
        }
        return false;
    }
}
