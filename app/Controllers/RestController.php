<?php

namespace App\Controllers;

use \CodeIgniter\HTTP\RequestInterface;
use \CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Model;
use \Psr\Log\LoggerInterface;

abstract class RestController extends BaseController
{

    public abstract function index();
    public abstract function new();
    public abstract function create();
    public abstract function show($id);
    public abstract function edit($id);
    public abstract function update($id);
    public abstract function delete($id);
}
