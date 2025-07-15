<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\{Contact, Invoice, Transaction};
use App\Models\{InvoiceModel, TransactionModel, ItemModel, ContactModel};
use CodeIgniter\I18n\Time;
use Ramsey\Uuid\Uuid;

use App\Validation\Validators\{InvoiceValidator,TransactionValidator};

class InvoiceController extends BaseController
{
  protected InvoiceModel $model;
  protected TransactionModel $transaction_model;
  protected ItemModel $item_model;
  protected ContactModel $contact_model;
  protected InvoiceValidator $form_invoice_validator;
  protected TransactionValidator $form_transaction_validator;
  public function __construct() {
    $this->model = new InvoiceModel();
    $this->transaction_model = new TransactionModel();
    $this->item_model = new ItemModel();
    $this->contact_model = new ContactModel();
    $this->form_invoice_validator = new InvoiceValidator();
    $this->form_transaction_validator = new TransactionValidator();

    helper('form');
    helper('session');
  }
  
  public function index()
  {
    $current_page = session()->get('current_page');
    if (is_admin() && $current_page) return redirect()->to($current_page);

    if (!user_logged()) return redirect()->to('/');
    else session()->set('current_page', 'invoices');

    $data['title'] = 'Facturas';
    $data['invoices'] = $this->model->findAllByBusiness(uuid_to_bytes(session()->get('business_id')));
    return view('Invoice/index', $data);
  }
  public function new()
  {
    $current_page = session()->get('current_page');
    if (is_admin() && $current_page) return redirect()->to($current_page);

    if (!user_logged()) return redirect()->to('/');
    else session()->set('current_page', 'invoices/new');
    
    $all_items = $this->item_model->findAllWithCategory(uuid_to_bytes(session()->get('business_id')));
    $income_items = array_filter($all_items, function($value) { return $value->category_type === 'income';});
    $expense_items = array_filter($all_items, function($value) { return $value->category_type === 'expense';});
    $items = (object) ['income' => array_values($income_items), 'expense' => array_values($expense_items)];
    
    $all_contacts = $this->contact_model->findAllByBusiness(uuid_to_bytes(session()->get('business_id')));
    $customer_contacts = array_filter($all_contacts, function($value) { return $value->type === 'customer';});
    $provider_contacts = array_filter($all_contacts, function($value) { return $value->type === 'provider';});
    $contacts = (object) ['customer' => array_values($customer_contacts), 'provider' => array_values($provider_contacts)];
    $data = [
        'title' => 'Nueva Factura',
        'items' => $items,  
        'contacts' => $contacts  
    ];
    return view('Invoice/new', $data);
  }
  public function show($id = null)
  {
    $current_page = session()->get('current_page');
    if (is_admin() && $current_page) return redirect()->to($current_page);

    if (!user_logged()) return redirect()->to('/');
    else session()->set('current_page', "invoices/$id");

    $invoice = $this->model->find(uuid_to_bytes($id));
    $transactions = $this->transaction_model->findAllByInvoice(uuid_to_bytes($id));
    $contact = $this->contact_model->find(uuid_to_bytes($invoice->contact_id));

    $data = [
        'title' => 'Información de Factura',
        'invoice' => $invoice,
        'transactions' => $transactions,
        'contact' => $contact,
    ];
    return view('Invoice/show', $data);
  }

  public function create()
  {
    $invoice = $this->request->getPost(
      ['invoice_date','due_date', 'payment_status', 'payment_method', 'contact_id']
    );
    $transactions = $this->request->getPost(
      ['transactions']
    )['transactions'];

    if (!$this->validate($this->form_invoice_validator->newRules()) ||
      !$this->validate($this->form_transaction_validator->newRules())) {
      return redirect()->back()->withInput();
    }
    
    $invoice['id'] = Uuid::uuid4();
    $invoice['business_id'] = uuid_to_bytes(session()->get('business_id'));
    $invoice['invoice_date'] = date('Y-m-d H:i:s', Time::now()->timestamp);
    $invoice['invoice_number'] = strval(Time::now()->timestamp);
    $invoice['due_date'] = date('Y-m-d', new Time($invoice['due_date'])->timestamp);
    $invoice['contact_id'] = uuid_to_bytes($invoice['contact_id']);
    
    $transactions_objects = [];
    foreach ($transactions as $transaction) {
      $transaction['invoice_id'] = $invoice['id'];
      array_push($transactions_objects, new Transaction($transaction));
    }

    $this->model->insert(new Invoice($invoice));
    $this->transaction_model->insertBatch($transactions_objects);
    return redirect()->to('invoices/new')->with('success', 'Transacción registrada exitosamente.');
  }
  public function update($id = null)
  {
    $post = $this->request->getPost(
      ['due_date', 'payment_status', 'payment_method', 'contact_id']
    );
    $row = [];
    foreach ($post as $key => $value) {
      if ($value) $row[$key] = $value;
    }
    if (empty($row)) return redirect()->to('invoices');
    
    if (!$this->validate($this->form_invoice_validator->showRules())) {
      return redirect()->back()->withInput(); 
    }

    $this->model->update(uuid_to_bytes($id), new Invoice($row));
    return redirect()->to('invoices');
  }
}
