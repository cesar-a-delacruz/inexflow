<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\User;
use App\Models\{UserModel, BusinessModel};
use CodeIgniter\Config\Services;
use Ramsey\Uuid\Uuid;

class UserController extends BaseController
{
    protected UserModel $model;
    protected BusinessModel $business_model;
    public function __construct() {
        $this->model = new UserModel();
        $this->business_model = new BusinessModel();
    }
    
    public function index()
    {
        $invalid_session = $this->checkSession(null);
        if ($invalid_session !== false) return $invalid_session;
        session()->set('current_page', 'user/');

        $data['title'] = 'Lista de Usuarios';
        $data['users'] = $this->model->findAll();
        return view('/User/index', $data);
    }
    public function login()
    {
        $current_page = session()->get('current_page');
        if ($current_page !== null) return redirect()->to($current_page);

        $data['title'] = 'Iniciar Sesión';
        return view('/User/login', $data);
    }
    public function new()
    {
        $invalid_session = $this->checkSession(null);
        if ($invalid_session !== false) return $invalid_session;
        session()->set('current_page', 'user/new');

        $data['title'] = 'Registrar Usuario';
        return view('/User/new', $data);
    }
    public function show($id = null)
    {
        $invalid_session = $this->checkSession($id);
        if ($invalid_session !== false) return $invalid_session;
        session()->set('current_page', 'user/'.$id);
        
        $data['title'] = 'Perfil del Usuario';
        $user = $this->model->find(uuid_to_bytes($id));
        $user->business = ($user->business_id)
        ? $this->business_model->find(uuid_to_bytes($user->business_id))->business_name : 'NULO';
        $data['user'] = $user;
        return view('/User/show', $data);
    }

    public function create()
    {
        $post = (object) $this->request->getPost(['name', 'email', 'password', 'role']);
        $this->model->createUser(new User([
            'id' => Uuid::uuid3(Uuid::NAMESPACE_URL, strval(($this->model->getStats()['total'] + 1))),
            'business_id' => null,
            'name' => $post->name,
            'email' => $post->email,
            'password' => $post->password,
            'role' => $post->role,
        ]));
        return redirect()->to('user/');
    }
    public function delete($id = null)
    {
        $user = $this->model->find(uuid_to_bytes($id));
        $this->business_model->deleteBusiness($user->business_id);
        $this->model->delete(uuid_to_bytes($id));
        return redirect()->to('user/');
    }
    public function verify()
    {
        $post = (object) $this->request->getPost(['email', 'password']);
        $user = $this->model->findByEmail($post->email);
        
        $is_invalid = $this->validateUser($user, $post);
        if ($is_invalid !== false) return $is_invalid;

        $init_page = match ($user->role) {
            'admin' => '/user',
            'businessman' => $user->getBusinessIdAsString() ?
                '/user/'.$user->getIdAsString().'/business' : '/user/'.$user->getIdAsString()
        };
        session()->set([
            'id'         => $user->getIdAsString(),
            'name'       => $user->name,
            'email'      => $user->email,
            'role'       => $user->role,
            'current_page' => $init_page
        ]);
        return redirect()->to($init_page);   
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
    public function update($id = null)
    {
        $user = new User($this->request->getPost(['name', 'email']));
        $this->model->updateUser($id, $user);
        return redirect()->to("/user/$id");
    }

    private function validateUser($user, $post) 
    {
        if (!$user) {
            return redirect()->back()->with('error', 'Usuario no encontrado.');
        } else if (!$user->verifyPassword($post->password)) {
            return redirect()->back()->with('error', 'Contraseña incorrecta.');
        } else if (!$user->isActive()) {
            return redirect()->back()->with('error', 'Cuenta inactiva. Contacte al administrador.');
        }
        return false;
    }
    private function checkSession($id) {
        $current_page = session()->get('current_page');
        if ($current_page === null) {
            return redirect()->to('/');
        }
        switch ($id) {
            case !null:
                if (session()->get('id') !== $id) {
                    return redirect()->to($current_page);
                }
                break;
            case null:
                if (session()->get('role') !== 'admin') {
                    return redirect()->to($current_page);
                }
                break;
        }
        return false;
    }
}
