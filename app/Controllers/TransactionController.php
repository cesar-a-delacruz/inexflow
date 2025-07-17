<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\{Transaction, Record};
use App\Models\{TransactionModel, RecordModel, ItemModel, ContactModel};
use CodeIgniter\I18n\Time;
use Ramsey\Uuid\Uuid;

use App\Validation\Validators\{TransactionValidator, RecordValidator};

class TransactionController extends BaseController
{
  protected $model;
  protected $formValidator;
  protected $recordModel;
  protected $recordValidator;
  protected $itemModel;
  protected $contactModel;

  public function __construct() 
  {
    $this->model = new TransactionModel();
    $this->formValidator = new TransactionValidator();
    $this->recordModel = new RecordModel();
    $this->recordValidator = new RecordValidator();
    $this->itemModel = new ItemModel();
    $this->contactModel = new ContactModel();
  }
  
  // vistas
  public function index()
  {
    if (!session()->get('business_id')) return redirect()->to('business/new');
    $redirect = check_user('businessman');
    if ($redirect !== null) return redirect()->to($redirect);
    else session()->set('current_page', 'transactions');

    $data = [
      'title' => 'Transacciones',
      'transactions' => $this->model->findAllWithContact(session()->get('business_id'))
    ];
    return view('Transaction/index', $data);
  }

  public function new()
  {
    if (!session()->get('business_id')) return redirect()->to('business/new');
    $redirect = check_user('businessman');
    if ($redirect !== null) return redirect()->to($redirect);
    else session()->set('current_page', 'transactions/new');
    
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
      'title' => 'Nueva Transacción',
      'items' => $items,  
      'contacts' => $contacts  
    ];
    return view('Transaction/new', $data);
  }

  public function show($id = null)
  {
    if (!session()->get('business_id')) return redirect()->to('business/new');
    $redirect = check_user('businessman');
    if ($redirect !== null) return redirect()->to($redirect);
    else session()->set('current_page', "transactions/$id");

    $transaction = $this->model->find(uuid_to_bytes($id));
    $records = $this->recordModel->findAllByTransaction(uuid_to_bytes($id));
    $contact = $this->contactModel->find(uuid_to_bytes($transaction->contact_id));

    $data = [
      'title' => 'Información de Transacción',
      'transaction' => $transaction,
      'records' => $records,
      'contact' => $contact,
    ];
    return view('Transaction/show', $data);
  }

  // peticiones
  public function create()
  {
    if (!$this->validate($this->formValidator->create) ||
      !$this->validate($this->recordValidator->create)) {
      return redirect()->back()->withInput();
    }

    $post = $this->request->getPost();
    
    $post['id'] = Uuid::uuid4();
    $post['business_id'] = uuid_to_bytes(session()->get('business_id'));
    $post['contact_id'] = ($post['contact_id'] !== '') ? uuid_to_bytes($post['contact_id']) : null;
    $post['number'] = strval(Time::now()->timestamp);
    $post['due_date'] = date('Y-m-d', new Time($post['due_date'])->timestamp);
    
    $records = [];
    foreach ($post['records'] as $record) {
      $record['transaction_id'] = $post['id'];
      array_push($records, new Record($record));
    }

    $this->model->insert(new Transaction($post));
    $this->recordModel->insertBatch($records);
    return redirect()->to('transactions/new')->with('success', 'Transacción registrada exitosamente.');
  }

  public function update($id = null)
  {
    if (!$this->validate($this->formValidator->update)) {
      return redirect()->back()->withInput(); 
    }

    $post = $this->request->getPost();
    $row = [];
    foreach ($post as $key => $value) {
      if ($value && $key !== '_method') $row[$key] = $value;
    }
    if (empty($row)) return redirect()->to('transactions');

    $this->model->update(uuid_to_bytes($id), new Transaction($row));
    return redirect()->to('transactions')->with('success', 'Transacción actualizada exitosamente.');;
  }
}
