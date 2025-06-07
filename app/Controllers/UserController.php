<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{
    public function index()
    {
        return view('/User/index');
    }
    public function new()
    {
        return view('/User/new');
    }
}
