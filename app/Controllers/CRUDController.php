<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class CRUDController extends BaseController
{
    protected $businessId;
    protected $model;
    protected string $controllerPath;


    public function __construct(string $controllerPath)
    {
        $this->controllerPath = $controllerPath;
    }

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->businessId = $this->session->get('business_id');

        // si en la session no hay negocio algo anda mal, esto despues se tiene que cambiar
        if (!$this->businessId) {
            return redirect()->to('business/new');
        }

        //si no tiene id no debe poder hacer nada
        if (!$this->session->get('id')) {
            return redirect()->to('/');
        }

        // los admisn no deben de estra en esta seccion, luego se hace el de ellos.
        if ($this->session->get('role') !== 'businessman') {
            return redirect()->to($this->session->get('current_page'));
        }

        //esta se debe ejecutar en cada metodo para tener el pacth correcto, ej: /items/new o transacions/show
        $this->session->set('current_page', $this->controllerPath);

        // más cosas 
    }

    public function index() {}
}
