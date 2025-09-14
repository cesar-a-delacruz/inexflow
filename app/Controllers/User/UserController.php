<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    protected UserModel $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    public function profile()
    {
        return view(
            'User/profile',
            [
                'title' => 'Información Personal',
                'user' => $this->model->find(uuid_to_bytes(session('user_id')))
            ]
        );
    }
}
