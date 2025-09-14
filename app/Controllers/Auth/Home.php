<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;

class Home extends BaseController
{
    public function index()
    {
        return view('/home');
    }
}
