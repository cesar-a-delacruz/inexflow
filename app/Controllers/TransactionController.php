<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransactionsModel;

class TransactionController extends BaseController
{
  protected TransactionsModel $model;
  public function __construct() {
    $this->model = new TransactionsModel();
  }
  public function index()
    {
      $data['title'] = 'Transacciones';
      $data['transactions'] = $this->model->findAll();
      return view('Transaction/index', $data);
    }
}
