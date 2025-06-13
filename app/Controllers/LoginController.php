<?php

namespace App\Controllers;

use App\Models\UserModel;

class LoginController extends BaseController
{

    public function index()
    {
        $data['title'] = 'Iniciar Sesión'; 
        return view('User/loginII',$data );
        
    }

    public function procesarLogin()
    {
      
        helper('url'); 
        $session = session();
        $model = new UserModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('passw');

        /** @var \App\Entities\User|null $user */
        $user = $model->findByEmail($email);

        if ($user) {
         
            if ($user->verifyPassword($password)) {
              
                if (!$user->isActive()) {
                    return redirect()->back()->with('error', 'Cuenta inactiva. Contacte al administrador.');
                }

                $session->set([
                    'id'         => $user->getIdAsString(),
                    'name'       => $user->name,
                    'email'      => $user->email,
                    'role'       => $user->role,
                    'isLoggedIn' => true
                ]);

               
                return match ($user->role) {
                'admin' => redirect()->to(base_url('/dashboard/admin')),
                'businessman' => redirect()->to(base_url('/dashboard/business')),
               
};

            } else {
                return redirect()->back()->with('error', 'Contraseña incorrecta.');
            }
        } else {
            return redirect()->back()->with('error', 'Usuario no encontrado.');
        }  
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/login'));
    }

    public function recovery()
    {
        return view('User/recovery');
    }
}
