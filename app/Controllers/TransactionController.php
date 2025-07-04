<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransactionsModel;

class TransactionController extends BaseController
{
  protected TransactionsModel $model;
  public function __construct() {
    $this->model = new TransactionsModel();
    helper('session');
  }
  
  public function index()
    {
      $current_page = session()->get('current_page');
      if (is_admin() && $current_page) return redirect()->to($current_page);

      if (!user_logged()) return redirect()->to('/');
      else session()->set('current_page', 'transactions');

      $data['title'] = 'Transacciones';
      $data['transactions'] = $this->model->findAllWithCategory();
      return view('Transaction/index', $data);
    }
}
