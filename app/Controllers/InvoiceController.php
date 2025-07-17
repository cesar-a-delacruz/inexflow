<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\{Invoice, Transaction};
use App\Models\{InvoiceModel, TransactionModel, ItemModel, ContactModel};
use CodeIgniter\I18n\Time;
use Ramsey\Uuid\Uuid;

use App\Validation\Validators\{InvoiceValidator, TransactionValidator};

class InvoiceController extends BaseController
{
  protected $model;
  protected $formValidator;
  protected $transactionModel;
  protected $transactionValidator;
  protected $itemModel;
  protected $contactModel;

  public function __construct() 
  {
    $this->model = new InvoiceModel();
    $this->formValidator = new InvoiceValidator();
    $this->transactionModel = new TransactionModel();
    $this->transactionValidator = new TransactionValidator();
    $this->itemModel = new ItemModel();
    $this->contactModel = new ContactModel();
  }
  
  // vistas
  public function index()
  {
    $redirect = check_user('businessman');
    if ($redirect !== null) return redirect()->to($redirect);
    else session()->set('current_page', 'invoices');

    $data = [
      'title' => 'Facturas',
      'invoices' => $this->model->findAllWithContact(session()->get('business_id'))
    ];
    return view('Invoice/index', $data);
  }

  public function new()
  {
    $redirect = check_user('businessman');
    if ($redirect !== null) return redirect()->to($redirect);
    else session()->set('current_page', 'invoices/new');
    
    $items = $this->itemModel->findAllWithCategory(session()->get('business_id'));
    $items = (function($array) {
      $income = [];
      $expense = [];
      
      foreach ($array as $item) {
        if ($item->category_type === 'income') array_push($income, $item);
        else array_push($expense, $item);
      }

      return (object) ['income' => $income, 'expense' => $expense];
    })($items);
    $contacts = $this->contactModel->findAllByBusiness(session()->get('business_id'));
    $contacts = (function($array) {
      $customer = [];
      $provider = [];
      
      foreach ($array as $item) {
        if ($item->category_type === 'customer') array_push($customer, $item);
        else array_push($provider, $item);
      }

      return (object) ['customer' => $customer, 'provider' => $provider];
    })($contacts);
    
    $data = [
      'title' => 'Nueva Factura',
      'items' => $items,  
      'contacts' => $contacts  
    ];
    return view('Invoice/new', $data);
  }

  public function show($id = null)
  {
    $redirect = check_user('businessman');
    if ($redirect !== null) return redirect()->to($redirect);
    else session()->set('current_page', "invoices/$id");

    $invoice = $this->model->find(uuid_to_bytes($id));
    $transactions = $this->transactionModel->findAllByInvoice(uuid_to_bytes($id));
    $contact = $this->contactModel->find(uuid_to_bytes($invoice->contact_id));

    $data = [
      'title' => 'Información de Factura',
      'invoice' => $invoice,
      'transactions' => $transactions,
      'contact' => $contact,
    ];
    return view('Invoice/show', $data);
  }

  // peticiones
  public function create()
  {
    if (!$this->validate($this->formValidator->create) ||
      !$this->validate($this->transactionValidator->newRules())) {
      return redirect()->back()->withInput();
    }

    $post = $this->request->getPost();
    
    $post['id'] = Uuid::uuid4();
    $post['business_id'] = uuid_to_bytes(session()->get('business_id'));
    $post['contact_id'] = ($post['contact_id'] !== '') ? uuid_to_bytes($post['contact_id']) : null;
    $post['number'] = strval(Time::now()->timestamp);
    $post['due_date'] = date('Y-m-d', new Time($post['due_date'])->timestamp);
    
    $transactions = [];
    foreach ($post['transactions'] as $transaction) {
      $transaction['invoice_id'] = $post['id'];
      array_push($transactions, new Transaction($transaction));
    }

    $this->model->insert(new Invoice($post));
    $this->transactionModel->insertBatch($transactions);
    return redirect()->to('invoices/new')->with('success', 'Factura registrada exitosamente.');
  }
  
  public function update($id = null)
  {
    if (!$this->validate($this->formValidator->update)) {
      return redirect()->back()->withInput(); 
    }

    $post = $this->request->getPost();
    $row = [];
    foreach ($post as $key => $value) {
      if ($value) $row[$key] = $value;
    }
    if (empty($row)) return redirect()->to('invoices');

    $this->model->update(uuid_to_bytes($id), new Invoice($row));
    return redirect()->to('invoices')->with('success', 'Factura actualizada exitosamente.');;
  }
}
