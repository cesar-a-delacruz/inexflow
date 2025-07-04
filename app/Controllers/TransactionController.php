<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Transaction;
use App\Models\CategoryModel;
use App\Models\TransactionsModel;
use App\Validation\Validators\TransactionValidator;
use CodeIgniter\I18n\Time;

class TransactionController extends BaseController
{
  protected TransactionsModel $model;
  protected CategoryModel $category_model;
  protected TransactionValidator $form_validator;
  public function __construct() {
    $this->model = new TransactionsModel();
    $this->category_model = new CategoryModel();
    $this->form_validator = new TransactionValidator();

    helper('form');
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
  public function new()
    {
        $current_page = session()->get('current_page');
        if (is_admin() && $current_page) return redirect()->to($current_page);

        if (!user_logged()) return redirect()->to('/');
        else session()->set('current_page', 'transactions/new');
        
        $categories = $this->category_model->getByBusiness(uuid_to_bytes(session()->get('business_id')));
        $data = [
            'title' => 'Nueva Transacción',
            'categories' => $categories  
        ];
        return view('Transaction/new', $data);
    }

    public function create()
    {
        $transaction = $this->request->getPost(
          ['description','category_number', 'amount', 'payment_method', 'notes']
        );
        if (!$this->validate($this->form_validator->newRules())) {
            return redirect()->back()->withInput();
        }

        $transaction['business_id'] = uuid_to_bytes(session()->get('business_id'));
        $transaction['transaction_date'] = date('Y-m-d', Time::now()->timestamp);

        $this->model->createTransaction(new Transaction($transaction));
        return redirect()->to('transactions/new')->with('success', 'Transacción exitosamente.');
    }
}
