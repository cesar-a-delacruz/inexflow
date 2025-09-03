<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\{Transaction, Record};
use App\Models\{TransactionModel, RecordModel, ItemModel, ContactModel};
use App\Validation\{TransactionValidator, RecordValidator};
use CodeIgniter\I18n\Time;
use Ramsey\Uuid\Uuid;

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
    $businessId = session()->get('business_id');

    if (!$businessId) return redirect()->to('business/new');
    $redirect = check_user('businessman');
    if ($redirect !== null) return redirect()->to($redirect);
    else session()->set('current_page', 'transactions');

    $data = [
      'title' => 'Transacciones',
      'transactions' => $this->model->findAllWithContact($businessId)
    ];
    helper('number');

    return view('Transaction/index', $data);
  }

  public function new()
  {
    $businessId = session()->get('business_id');

    if (!$businessId) return redirect()->to('business/new');
    $redirect = check_user('businessman');
    if ($redirect !== null) return redirect()->to($redirect);
    else session()->set('current_page', 'transactions/new');
    helper('number');

    $items = $this->itemModel->findAllWithCategory($businessId);
    $income = [];
    $expense = [];
    foreach ($items as $item) {
      if ($item->category_type === 'income') $income[] = $item;
      else $expense[] = $item;
    }

    $jsIncomes = [];
    if (!empty($income)) {
      foreach ($income as $i => $inc) {
        $jsIncomes[] = [
          'index' => $i,
          'id' => $inc->id->toString(),
          'name' => $inc->name,
          'category' => $inc->category_name,
          'type' => $inc->displayType(),
          'stock' => $inc->displayProperty('stock'),
          'money' => $inc->selling_price ?? $inc->cost,
        ];
      }
    }
    $jsExpense = [];
    if (!empty($expense)) {
      foreach ($expense as $i => $inc) {
        $jsExpense[] = [
          'index' => $i,
          'id' => $inc->id->toString(),
          'name' => $inc->name,
          'category' => $inc->category_name,
          'type' => $inc->displayType(),
          'stock' => $inc->displayProperty('stock'),
          'money' => $inc->selling_price ?? $inc->cost,
        ];
      }
    }
    $items = (object) ['income' => $income, 'expense' => $expense];

    $contacts = $this->contactModel->findAllByBusiness($businessId);
    $contacts = (function ($array) {
      $customer = [];
      $provider = [];

      foreach ($array as $contact) {
        if ($contact->type === 'customer') array_push($customer, $contact);
        else array_push($provider, $contact);
      }

      return (object) ['customer' => $customer, 'provider' => $provider];
    })($contacts);

    $jsCustomer = [];
    if (!empty($contacts->customer)) {
      foreach ($contacts->customer as $i => $inc) {
        $jsCustomer[] = [
          'index' => $i,
          'id' => $inc->id->toString(),
          'name' => $inc->name,
          'email' => $inc->email,
          'phone' => $inc->phone,
          'address' => $inc->address,
        ];
      }
    }
    $jsProvider = [];
    if (!empty($contacts->provider)) {
      foreach ($contacts->provider as $i => $inc) {
        $jsProvider[] = [
          'index' => $i,
          'id' => $inc->id->toString(),
          'name' => $inc->name,
          'email' => $inc->email,
          'phone' => $inc->phone,
          'address' => $inc->address,
        ];
      }
    }
    $data = [
      'title' => 'Nueva Transacción',
      'jsExpenses' => $jsExpense,
      'jsIncomes' => $jsIncomes,
      'jsProviders' => $jsProvider,
      'jsCustomers' => $jsCustomer
    ];


    return view('Transaction/new', $data);
  }

  public function show($id = null)
  {
    $businessId = session()->get('business_id');
    if (!$businessId) return redirect()->to('business/new');
    $redirect = check_user('businessman');
    if ($redirect !== null) return redirect()->to($redirect);
    else session()->set('current_page', "transactions/$id");

    $businessIdBytes = uuid_to_bytes($businessId);
    $transaction = $this->model->where('business_id', $businessIdBytes)->find(uuid_to_bytes($id));
    $records = $this->recordModel->findAllByTransaction($id, $businessId);
    $contact = $transaction->contact_id ? $this->contactModel->where('business_id', $businessIdBytes)->find(uuid_to_bytes($transaction->contact_id)) : 'Anónimo';

    $data = [
      'title' => 'Información de Transacción',
      'transaction' => $transaction,
      'records' => $records,
      'contact' => $contact,
    ];
    return view('Transaction/show', $data);
  }

  // acciones
  public function create()
  {
    if (
      !$this->validate($this->formValidator->create) ||
      !$this->validate($this->recordValidator->create)
    ) {
      return redirect()->back()->withInput();
    }

    $businessId = session()->get('business_id');
    $businessIdBytes = uuid_to_bytes($businessId);

    $post = $this->request->getPost();

    $transaction = [
      'id' => Uuid::uuid4(),
      'business_id' => $businessId,
      'contact_id' => ($post['contact_id']) ? uuid_to_bytes($post['contact_id']) : null,
      'number' => strval(Time::now()->timestamp),
      'due_date' => date('Y-m-d', new Time($post['due_date'])->timestamp),
      'total' => 0,
      'payment_method' => $post['payment_method'],
      'payment_status' => $post['payment_status'],
    ];

    $productsToEdit = [];
    $recordList = [];

    foreach ($post['records'] as $index => $record) {

      $itemId = $record['item_id'] ?? null;

      if (!$itemId) {
        return $this->sendError("No se especificó el producto o servicio.");
      }

      $item = $this->itemModel->where('business_id', $businessIdBytes)->find(uuid_to_bytes($itemId));

      if (!$item) {
        return $this->sendError("Un producto o servicio no fue encontrado.");
      }

      $recordData = [
        'transaction_id' => $transaction['id'],
        'business_id' => $businessId,
        'item_id' => $item->id,
        'description' => $item->name,
        'category' => $record['category'],
        'type' => $item->type,
      ];

      $sellingPrice = (int) ($item->selling_price ?? $item->cost);

      if (!$sellingPrice) {
        return $this->sendError("Un producto no tiene precio.");
      }

      if ($item->type !== 'product') {
        $recordData['amount'] = null;
        $recordData['unit_price'] = null;
        $recordData['subtotal'] = $sellingPrice;
        $transaction['total'] += $sellingPrice;
        $recordList[] = new Record($recordData);
        continue;
      }

      if (!isset($record['amount']) || empty($record['amount'])) {
        return $this->sendError("No se especificó la cantidad para {$item->name}.");
      }

      $amount = (int) ($record['amount'] ?? 0);
      $currentStock = (int) ($item->stock ?? 0);

      if ($amount <= 0) {
        return $this->sendError("Cantidad inválida para '{$item->name}'");
      }

      if ($currentStock < $amount) {
        return $this->sendError("Stock insuficiente para '{$item->name}'. Disponible: {$currentStock}, Solicitado: {$amount}.");
      }

      $subTotal = $sellingPrice * $amount;

      $recordData['amount'] = $amount;
      $recordData['unit_price'] = $sellingPrice;
      $recordData['subtotal'] = $subTotal;

      $productsToEdit[] = [
        'id' => uuid_to_bytes($item->id),
        'stock' => $currentStock - $amount,
      ];

      $transaction['total'] += $subTotal;
      $recordList[] = new Record($recordData);
    }

    // $post['id'] = Uuid::uuid4();
    // $post['business_id'] = uuid_to_bytes($businessId);
    // $post['contact_id'] = ($post['contact_id']) ? uuid_to_bytes($post['contact_id']) : null;
    // $post['number'] = strval(Time::now()->timestamp);
    // $post['due_date'] = date('Y-m-d', new Time($post['due_date'])->timestamp);

    // $records = [];
    // foreach ($post['records'] as $record) {
    //   $record['transaction_id'] = $post['id'];
    //   $record['business_id'] = $post['business_id'];
    //   if (!isset($record['amount'])) $record['amount'] = null;
    //   $entity = new Record($record);
    //   $records = $entity;
    // }

    $this->model->insert(new Transaction($transaction));
    $this->recordModel->insertBatch($recordList);

    foreach ($productsToEdit as $item) {
      $this->itemModel->update(($item['id']), ['stock' => $item['stock']]);
    }
    // $this->itemModel->updateBatch($stockValidation, 'id');

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

  protected function sendError(string $message)
  {
    $validation = \Config\Services::validation();
    $validation->setError('stock', $message);

    return redirect()->back()->withInput();
  }
}
