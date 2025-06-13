<?php

namespace App\Controllers;

class DashboardController extends BaseController
{
    public function __construct(){
        helper('url');
    }
    
    public function index()
    {
        
        $session = session();

        if (!$session->get('isLoggedIn'))  {
            return redirect()->to('/login')->with('error','Sesión expirada');
        }

     
       
        $data = [
            'userName' => $session->get('name'),
            'role' => $session->get('role')
        ];

       
        switch ($session->get('role')) {
            case 'admin':
                return view('Dashboard/admin', array_merge($data, [
                    'title' => 'Panel de Administrador' 
                ]));
            
            case 'businessman':
                return view('Dashboard/business', array_merge($data, [
                    'title' => 'Panel Empresarial'
                ]));
            
            default:
                return view('Dashboard/default', $data);
        }

    }
}
