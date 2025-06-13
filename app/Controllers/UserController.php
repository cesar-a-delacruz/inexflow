<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\{UserModel, BusinessModel};

class UserController extends BaseController
{
    protected UserModel $model;

    public function __construct() {
        $this->model = new UserModel();
    }
    public function index()
    {
        $data['title'] = 'Perfil del Usuario';
        $data['user'] = $this->model->find(2);
        return view('/User/index', $data);
    }
    public function new()
    {
        return view('/User/new');
    }
    public function login()
    {
        return view('/User/login');
    }
    public function dashboard()
    {
        return view('/User/dashboard');
    }
    public function traders()
    {
      return view('/User/emprendedores');
    }
    public function reset()
    {
      return view('/User/recovery');
    }

}
