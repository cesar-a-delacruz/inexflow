<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class ProfileController extends BaseController
{
    protected UserModel $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    public function profile()
    {
        return view(
            'user/profile',
            [
                'title' => 'Información Personal',
                'user' => $this->model->find(uuid_to_bytes(session('user_id')))
            ]
        );
    }
}
