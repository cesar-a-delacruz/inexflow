<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class TransactionController extends BaseController
{
  public function index()
    {
      $data['title'] = 'Transacciones';
      return view('Transaction/index', $data);
    }
}
