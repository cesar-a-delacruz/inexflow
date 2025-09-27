<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Home extends BaseController
{
    protected UserModel $model;
    // protected string $segment;

    public function __construct()
    {
        // $this->segment = 'user';
        $this->model = new UserModel();
    }

    public function index()
    {
        $users = $this->model->findAll();
        return view('admin/user/new', ['title' => 'All Users', 'users' => $users]);
    }
}
