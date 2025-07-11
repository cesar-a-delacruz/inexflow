<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ItemModel;

class ItemController extends BaseController
{
  protected ItemModel $model;
  public function __construct() {
    $this->model = new ItemModel();

    helper('form');
    helper('session');
  }

    public function index()
    {
        $current_page = session()->get('current_page');
        if (is_admin() && $current_page) return redirect()->to($current_page);

        if (!user_logged()) return redirect()->to('/');
        else session()->set('current_page', 'items');

        $data['title'] = 'Productos y Servicios';
        $data['items'] = $this->model->findAllWithCategory();
        return view('Item/index', $data);
    }
}
