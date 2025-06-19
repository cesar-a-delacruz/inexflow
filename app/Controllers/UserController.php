<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\User;
use App\Models\{UserModel, BusinessModel};
use App\Validation\Validators\UserValidator;
use Ramsey\Uuid\Uuid;

class UserController extends BaseController
{
    protected UserModel $model;
    protected BusinessModel $business_model;
    protected UserValidator $form_validator;
    public function __construct() {
        $this->model = new UserModel();
        $this->business_model = new BusinessModel();
        $this->form_validator = new UserValidator();

        helper('form');
    }
    
    public function index()
    {
        $is_admin = $this->isAdmin();
        if ($is_admin !== true) return $is_admin;
        session()->set('current_page', 'users');

        $data['title'] = 'Usuarios';
        $data['users'] = array_values(array_filter(
            $this->model->findAll(), 
            function ($user) { return $user->id != session()->get('id'); }
        ));
        return view('User/index', $data);
    }
    public function login()
    {
        $current_page = session()->get('current_page');
        if ($current_page !== null) return redirect()->to($current_page);

        $data['title'] = 'Iniciar Sesión';
        return view('User/login', $data);
    }
    public function new()
    {
        $is_admin = $this->isAdmin();
        if ($is_admin !== true) return $is_admin;
        session()->set('current_page', 'users/new');
        
        $data['title'] = 'Nuevo Usuario';
        return view('User/new', $data);
    }
    public function recovery()
    {
        $current_page = session()->get('current_page');
        if ($current_page !== null) return redirect()->to($current_page);

        $data['title'] = 'Recuperar Contraseña';
        return view('User/recovery', $data);
    }
    public function show()
    {
        session()->set('current_page', 'user');
        $session_id = session()->get('id');
        
        $data['title'] = 'Información Personal';
        $user = $this->model->find(uuid_to_bytes($session_id));
        $user->business = ($user->business_id)
        ? $this->business_model->find(uuid_to_bytes($user->business_id))->business_name : 'NULO';
        $data['user'] = $user;
        return view('User/show', $data);
    }

    public function create()
    {
        $post = (object) $this->request->getPost(['name', 'email', 'password', 'role']);
        if (!$this->validate($this->form_validator->newRules())) {
            return redirect()->back()->withInput();
        }

        $this->model->createUser(new User([
            'id' => Uuid::uuid3(Uuid::NAMESPACE_URL, strval(($this->model->getStats()['total'] + 1))),
            'business_id' => null,
            'name' => $post->name,
            'email' => $post->email,
            'password' => $post->password,
            'role' => $post->role,
        ]));
        return redirect()->to('users');
    }
    public function delete($id = null)
    {
        $user = $this->model->find(uuid_to_bytes($id));
        
        if (!$this->validate($this->form_validator->indexRules())) {
            return redirect()->back()->withInput();
        }
        if ($user->business_id) $this->business_model->deleteBusiness($user->business_id);
            $this->model->delete(uuid_to_bytes($id));

        return redirect()->to('users');
    }
    public function activate($id = null) 
    {
        $this->model->toggleActive($id);
        return redirect()->to('users');
    }
    public function verify()
    {
        $post = (object) $this->request->getPost(['email', 'password']);
        $user = $this->model->findByEmail($post->email);

        if (!$this->validate($this->form_validator->loginRules())) {
            return redirect()->back()->withInput();
        }

        $init_page = match ($user->role) {
            'admin' => 'users',
            'businessman' => $user->business_id ? 'user/business' : 'user'
        };
        session()->set([
            'id' => $user->getIdAsString(),
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'current_page' => $init_page
        ]);
        return redirect()->to($init_page);   
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
    public function update()
    {
        $post = $this->request->getPost(['name', 'email']);
        $row = [];
        foreach ($post as $key => $value) {
            if ($value) $row[$key] = $value;
        }
        if (empty($row)) return redirect()->to('user');

        $user = new User($row);
        if (!$this->validate($this->form_validator->showRules())) {
            return redirect()->back()->withInput();
        }

        $this->model->updateUser(session()->get('id'), $user);
        return redirect()->to('user');
    }

    private function isAdmin() {
        $current_page = session()->get('current_page');
        if ($current_page === null) {
            return redirect()->to('/');
        } else if (session()->get('role') !== 'admin') {
            return redirect()->to($current_page);
        }
        return true;
    }
}
