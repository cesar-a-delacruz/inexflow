<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Home extends BaseController
{
    protected UserModel $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    public function index()
    {
        $users = $this->model->findAll();
        return view('admin/user/index', ['title' => 'Usuarios', 'users' => $users]);
    }
}
