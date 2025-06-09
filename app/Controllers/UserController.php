<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class UserController extends BaseController
{
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
}
