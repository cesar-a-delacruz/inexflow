<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ExampleModel;
use App\Models\ReportModel;

class ExampleController extends BaseController
{
    public function index()
    {
        $emodel = new ReportModel();
        $model = new ExampleModel();
        // echo "<h3>Estado de Resultados</h3><code><pre>";
        // print_r($emodel->getIncomeStatement("9311744c-3746-3502-84c9-d06e8b5ea2d6"));
        // echo "</pre> </code>";
        // echo "<div><canvas id='myChart'></canvas></div>";
        // echo "<hr>";
        // echo "<h3>Flujo de Caja</h3><code><pre>";
        // print_r($emodel->getCashFlow("9311744c-3746-3502-84c9-d06e8b5ea2d6", ["group_by" => "year"]));
        // echo "</pre> </code> <hr>";

        // echo "<h3>gastos por categoría</h3><code><pre>";
        // print_r($emodel->getCategoryAnalysis("9311744c-3746-3502-84c9-d06e8b5ea2d6"));
        // echo "</pre> </code> <hr>";

        // echo "<h3>rendimiento del negocio</h3><code><pre>";
        // print_r($emodel->getBusinessMetrics("9311744c-3746-3502-84c9-d06e8b5ea2d6"));
        // echo "</pre> </code> <hr>";

        // echo "<h3>análisis por método de pago</h3><code><pre>";
        // print_r($emodel->getPaymentMethodAnalysis("9311744c-3746-3502-84c9-d06e8b5ea2d6"));
        // echo "</pre> </code> <hr>";
        // echo "<h3>Estado de Resultados</h3><code><pre>";
        // print_r($model->getIncomeStatement("9311744c-3746-3502-84c9-d06e8b5ea2d6"));
        // echo "</pre> </code>";
        // echo "<h3>Estado de Resultados</h3><code><pre>";
        // print_r($model->getSalesAnalysis("9311744c-3746-3502-84c9-d06e8b5ea2d6"));
        // echo "</pre> </code>";
        // echo "<h3>Estado de Resultados</h3><code><pre>";
        // print_r($model->getContactsAnalysis("9311744c-3746-3502-84c9-d06e8b5ea2d6"));
        // echo "</pre> </code>";
        // echo "<h3>Estado de Resultados</h3><code><pre>";
        // print_r($model->getDashboardMetrics("9311744c-3746-3502-84c9-d06e8b5ea2d6"));
        // echo "</pre> </code>";
        $data = [
            "results" => [
                $model->getIncomeStatement("9311744c-3746-3502-84c9-d06e8b5ea2d6"),
                $model->getCashFlow("9311744c-3746-3502-84c9-d06e8b5ea2d6", ["group_by" => "year"]),
                $model->getCategoryAnalysis("9311744c-3746-3502-84c9-d06e8b5ea2d6"),
                $model->getBusinessMetrics("9311744c-3746-3502-84c9-d06e8b5ea2d6"),
                // $model->getPaymentMethodAnalysis("9311744c-3746-3502-84c9-d06e8b5ea2d6")
            ]
        ];
        return view('example', $data);
    }
}
