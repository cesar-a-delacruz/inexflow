<?php

namespace App\Controllers\Api;

use App\Models\ExampleModel;
use CodeIgniter\RESTful\ResourceController;

class ReportController extends ResourceController
{
    protected $modelName = 'App\Models\ReportModel';
    protected $format    = 'json';



    public function index()
    {
        $businessId = session()->get('business_id');

        if (!$businessId) return $this->respond("error", 400);

        $data = [
            'sales' => $this->model->getSalesChart($businessId)
        ];
        return $this->respond($data);
    }

    public function preflight()
    {
        return $this->response->setStatusCode(204);
    }


    public function incomeStatement()
    {
        $businessId = session()->get('business_id');

        if (!$businessId) return $this->respond("error", 400);

        return $this->respond($this->model->getIncomeStatement($businessId));
    }
    public function paymentStatus()
    {
        $businessId = session()->get('business_id');

        if (!$businessId) return $this->respond("error", 400);

        return $this->respond($this->model->getPaymentStatusChart($businessId));
    }
    public function paymentMethod()
    {
        $businessId = session()->get('business_id');

        if (!$businessId) return $this->respond("error", 400);

        return $this->respond($this->model->getPaymentMethodChart($businessId));
    }
    public function topItems()
    {
        $businessId = session()->get('business_id');

        if (!$businessId) return $this->respond("error", 400);

        return $this->respond($this->model->getTopItemsChart($businessId));
    }
}
