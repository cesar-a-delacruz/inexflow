<?php

namespace App\Controllers\Tenants;

use App\Controllers\RestController;
use App\Models\UserModel;

class UserController extends RestController
{
    protected UserModel $model;
    public function __construct()
    {
        $this->model = new UserModel();
    }

    public function index()
    {
        return view(
            'Tenants/User/index',
            [
                'title' => 'Usuarios del negocio',
                'user' => $this->model->findAllByBusiness(session('business_id'))
            ]
        );
    }

    public function new() {}
    public function create() {}
    public function show($id) {}
    public function edit($id) {}
    public function update($id) {}
    public function delete($id) {}
}
