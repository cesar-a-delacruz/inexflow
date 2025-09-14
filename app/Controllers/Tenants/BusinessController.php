<?php

namespace App\Controllers\Tenants;

use App\Controllers\BaseController;
use App\Models\BusinessModel;

class BusinessController extends BaseController
{
    protected BusinessModel $model;
    protected string $segment;

    public function __construct()
    {
        $this->segment = 'business';
        $this->model = new BusinessModel();
    }

    public function index()
    {
        $business = $this->model->find(uuid_to_bytes(session('business_id')));
        return view('Tenants/Business/show', [
            'title' => 'Negocio - ' . $business->name,
            'business' => $business,
        ]);
    }
}
