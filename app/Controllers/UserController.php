<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class UserController extends BaseController
{
    public function index()
    {
        $data['title'] = 'Perfil del Usuario';
        return view('/User/index', $data);
    }
    public function new()
    {
        return view('/User/new');
    }
}
