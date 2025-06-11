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

    public function show($id = null)
    {
        $data['title'] = 'Perfil del Usuario';
        $user = $this->model->find($id);
        $user->business = ($user->business_id)
        ? new BusinessModel()->find($user->business_id)->business_name : 'No Aplica';
        $data['user'] = $user;
        return view('/User/show', $data);
    }
    public function update($id = null)
    {
        $post = $this->request->getPost(['name', 'email']);
        $this->model->update($id, [
            'name' => trim($post['name']),
            'email' => trim($post['email']),
        ]);
        return redirect()->to("/user/$id");
    }
    public function new()
    {
        return view('/User/new');
    }
}
