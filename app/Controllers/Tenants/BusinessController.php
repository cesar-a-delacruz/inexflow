<?php

namespace App\Controllers\Tenants;

use App\Controllers\BaseController;
use App\Models\BusinessModel;

class BusinessController extends BaseController
{
    protected BusinessModel $model;

    public function __construct()
    {
        $this->model = new BusinessModel();
    }

    public function index()
    {
        echo 'Busines';
    }
}
