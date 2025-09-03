<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ReportModel;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    protected ReportModel $model;
    public function __construct()
    {
        $this->model = new ReportModel();
    }
    public function index()
    {
        $businessId = session()->get('business_id');

        if (!$businessId) throw redirect("/");
        $groupBy = $this->request->getGet('group_by') ?? '';
        $productLimit = $this->request->getGet('product_limit') ?? 10;

        if ($productLimit > 50 || $productLimit < 10) $productLimit = 10;

        $filters = [];

        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');

        if (isset($startDate)) $filters['start_date'] = $startDate;
        if (isset($endDate)) $filters['end_date'] = $endDate;
        if (isset($productLimit)) $filters['product_limit'] = $productLimit;

        $data = [
            'title' => 'Dashboard',
            'sales' => $this->model->getSalesChart($businessId, $filters, $groupBy),
            'dateValues' => ReportModel::$dateValues,
            'filters' => $filters,
            'paymentMethodData' => $this->model->getPaymentMethodChart($businessId, $filters),
            'paymentStatusData' => $this->model->getPaymentStatusChart($businessId, $filters),
            'topItems' => $this->model->getTopItemsChart($businessId, $filters, $productLimit),
        ];

        array_push($data, $filters);
        return view('/Dashboard/index', $data);
    }
    /*
    "getSalesChart": {
        "data": [
            {
                "period": "2025-07-21",
                "total_sales": "40.00",
                "transactions_count": "1"
            },
            {
                "period": "2025-07-28",
                "total_sales": "100.00",
                "transactions_count": "1"
            },
            {
                "period": "2025-07-29",
                "total_sales": "185.00",
                "transactions_count": "3"
            }
        ],
        "period_description": "Todos los registros",
        "group_by": "day"
    }
}
     */
}
