<?php

namespace App\Controllers\Tenants;

use App\Controllers\RestController;
use App\Models\ItemModel;

class ItemController extends RestController
{
    protected ItemModel $model;

    public function __construct()
    {
        $this->model = new ItemModel();
    }
    public function index()
    {
        $items = $this->model->findAllByBusinesId(session('business_id'));
        helper('number');
        return view(
            'Tenants/Item/index',
            [
                'title' => 'Elementos',
                'items' => $items
            ]
        );
    }

    public function new() {}
    public function create() {}
    public function show($id) {}
    public function edit($id) {}
    public function update($id) {}
    public function delete($id) {}
}
