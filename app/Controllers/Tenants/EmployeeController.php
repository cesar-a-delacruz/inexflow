<?php

namespace App\Controllers\Tenants;

use App\Controllers\BaseController;
use App\Controllers\RestController;
use App\Models\UserModel;
use App\Validation\UserValidator;

class EmployeeController extends BaseController implements RestController
{
    protected UserModel $model;
    protected UserValidator $formValidator;
    protected string $segment;

    public function __construct()
    {
        $this->segment = 'employees';
        $this->model = new UserModel();
    }

    public function index()
    {
        $employees = $this->model->findAllByBusiness(session('business_id'));

        return view(
            'tenants/employee/index',
            [
                'title' => 'Empleados',
                'employees' => $employees,
                'segment' => $this->segment,
            ]
        );
    }

    public function show($id)
    {
        return redirect()->to('/tenants/' . $this->segment);
    }

    public function edit($id)
    {
        return redirect()->to('/tenants/' . $this->segment);
    }

    public function new()
    {
        return redirect()->to('/tenants/' . $this->segment);
    }
    public function create()
    {
        return redirect()->to('/tenants/' . $this->segment);
    }

    public function update($id)
    {
        return redirect()->to('/tenants/' . $this->segment);
    }

    public function delete($id)
    {
        return redirect()->to('/tenants/' . $this->segment);
    }
}
