<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\User;
use App\Models\{UserModel, BusinessModel};
use App\Validation\UserValidator;
use Ramsey\Uuid\Uuid;

class UserController extends BaseController
{
    protected $model;
    protected $businessModel;
    protected $formValidator;

    public function __construct() {
        $this->model = new UserModel();
        $this->businessModel = new BusinessModel();
        $this->formValidator = new UserValidator();
    }
    
    // vistas
    public function index()
    {
        $redirect = check_user('admin');
        if ($redirect !== null) return redirect()->to($redirect);
        else session()->set('current_page', 'users');

        $data = [
            'title' => 'Usuarios',
            'users' => array_values(array_filter($this->model->findAll(), function ($user) { return $user->id != session()->get('id'); }))
        ];
        return view('User/index', $data);
    }
    
    public function new()
    {
        $redirect = check_user('admin');
        if ($redirect !== null) return redirect()->to($redirect);
        else session()->set('current_page', 'users/new');

        $data['title'] = 'Nuevo Usuario';
        return view('User/new', $data);
    }

    public function show()
    {
        $redirect = check_user('businessman');
        if ($redirect !== null) return redirect()->to($redirect);
        else session()->set('current_page', 'user');
        
        $data = [
            'title' => 'Información Personal',
            'user' => $this->model->find(uuid_to_bytes(session()->get('id')))
        ];
        return view('User/show', $data);
    }

    public function login()
    {
        if (user_logged()) return redirect()->to(session()->get('current_page'));

        $data['title'] = 'Iniciar Sesión';
        return view('User/login', $data);
    }

    // vistas no alteradas
    public function token()
    {
        $current_page = session()->get('current_page');
        if (user_logged()) return redirect()->to($current_page);

        if ($this->request->getServer('REQUEST_METHOD') == 'POST') {
            return redirect()->to('password');
        }

        $data['title'] = 'Código de Verificación';
        return view('User/token', $data);
    }

    public function password()
    {
        $current_page = session()->get('current_page');
        if (user_logged()) return redirect()->to($current_page);

        if ($this->request->getServer('REQUEST_METHOD') == 'POST') {
            return redirect()->to('/');
        }

        $data['title'] = 'Cambiar Contraseña';
        return view('User/password', $data);
    }

    public function recovery()
    {
        $current_page = session()->get('current_page');
        if (user_logged()) return redirect()->to($current_page);

        if ($this->request->getServer('REQUEST_METHOD') == 'POST') {
            if (!$this->validate($this->formValidator->recovery)) {
                return redirect()->back()->withInput();
            }
            return redirect()->to('token');
        }

        $data['title'] = 'Recuperar Cuenta';
        return view('User/recovery', $data);
    }
    // fin de vistas no alteradas

    // acciones
    public function create()
    {
        if (!$this->validate($this->formValidator->create)) {
            return redirect()->back()->withInput();
        }

        $post = $this->request->getPost();
        $post['id'] = Uuid::uuid4();

        $this->model->insert(new User($post));
        return redirect()->to('users/new')->with('success', 'Usuario creado exitosamente.');
    }

    public function update()
    {
        if (!$this->validate($this->formValidator->update)) {
            return redirect()->back()->withInput();
        }
        
        $post = $this->request->getPost();
        if ($post['name']) session()->set('name', $post['name']);
        if ($post['email']) session()->set('email', $post['email']);

        $row = [];
        foreach ($post as $key => $value) {
            if ($value && $key !== '_method') $row[$key] = $value;
        }
        if (empty($row)) return redirect()->to('user');

        $this->model->update(uuid_to_bytes(session()->get('id')), new User($row));
        return redirect()->to('user');
    }

    public function delete($id = null)
    {
        if (!$this->validate($this->formValidator->delete)) {
            return redirect()->back()->withInput();
        }

        $user = $this->model->find(uuid_to_bytes($id));
        if ($user->business_id) $this->businessModel->delete(uuid_to_bytes($user->business_id));

        if ($this->model->delete(uuid_to_bytes($id))) {
            return redirect()->to('users')->with('success', 'Usuario eliminado exitosamente.');
        } else {
            return redirect()->to('users')->with('error', 'No se pudo eliminar el usuario.');
        }
    }

    public function activate($id = null) 
    {
        $this->model->toggleActive($id);
        return redirect()->to('users');
    }

    public function verify()
    {
        if (!$this->validate($this->formValidator->login)) {
            return redirect()->back()->withInput();
        }

        $post = $this->request->getPost();
        $user = $this->model->findByEmail($post['email']);
        $init_page = match ($user->role) {
            'admin' => 'users',
            'businessman' => $user->business_id ? 'business' : 'user'
        };
        
        session()->set([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'business_id' => $user->business_id ? $user->business_id : null,
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
