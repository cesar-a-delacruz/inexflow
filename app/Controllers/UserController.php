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
    public function show($id = null)
    {
        $data['title'] = 'Perfil del Usuario';
        $data['user'] = $this->model->find($id);
        return view('/User/show', $data);
    }
    public function edit($id = null)
    {
        $data['title'] = 'Editar Perfil';
        $data['user'] = $this->model->find($id);
        return view('/User/edit', $data);
    }
    public function new()
    {
        return view('/User/new');
    }
}
