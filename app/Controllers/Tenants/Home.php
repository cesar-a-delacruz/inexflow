<?php

namespace App\Controllers\Tenants;

use App\Controllers\BaseController;

class Home extends BaseController
{
    public function index()
    {
        return view('/home');
    }
}
