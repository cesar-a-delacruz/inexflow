<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\{Transaction, Record};
use App\Models\{TransactionModel, RecordModel, ItemModel, ContactModel};
use App\Validation\{TransactionValidator, RecordValidator};
use CodeIgniter\I18n\Time;
use Ramsey\Uuid\Uuid;

class TransactionController extends CRUDController
{
  protected $formValidator;
  protected $recordModel;
  protected $recordValidator;
  protected $itemModel;
  protected $contactModel;


  public function __construct()
  {
    $this->controllerPath = 'transitions';
  }

  // vistas
  public function index()
  {
    $this->model = new TransactionModel();

    $data = [
      'title' => 'Transacciones',
      'transactions' => $this->model->findAllWithContact($this->businessId)
    ];

    helper('number');
    helper('date');


    return view('Transaction/index', $data);
  }

  public function new()
  {
    $this->itemModel = new ItemModel();
    $this->contactModel = new ContactModel();

    $items = $this->itemModel->findAllWithCategory($this->businessId);

    $jsIncomes = [];
    $jsExpense = [];

    foreach ($items as $i => $item) {
      $data = [
        'index' => $i,
        'id' => $item->id->toString(),
        'name' => $item->name,
        'category' => $item->category_name,
        'measure_unit' => $item->measure_unit,
        'type' => $item->type->label(),
        'stock' => $item->displayProperty('stock'),
        'money' => $item->selling_price ?? $item->cost,
      ];

      if ($item->category_type === 'income')
        $jsIncomes[] = $data;
      else
        $jsExpense[] = $data;
    }

    $jsCustomer = [];
    $jsProvider = [];

    $contacts = $this->contactModel->findAllByBusiness($this->businessId);


    foreach ($contacts as $i => $contact) {
      $data = [
        'index' => $i,
        'id' => $contact->id->toString(),
        'name' => $contact->name,
        'email' => $contact->email,
        'phone' => $contact->phone,
        'address' => $contact->address,
      ];
      if ($contact->type === 'customer')
        $jsCustomer[] = $data;
      else
        $jsProvider[] = $data;
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
    $this->model = new TransactionModel();
    $this->recordModel = new RecordModel();
    $this->contactModel = new ContactModel();

    $businessIdBytes = uuid_to_bytes($this->businessId);

    $transaction = $this->model->where('business_id', $businessIdBytes)->find(uuid_to_bytes($id));
    $records = $this->recordModel->findAllByTransaction($id, $this->businessId);
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
    $this->formValidator = new TransactionValidator();
    $this->recordValidator = new RecordValidator();

    if (
      !$this->validate($this->formValidator->create) ||
      !$this->validate($this->recordValidator->create)
    ) {
      return redirect()->back()->withInput();
    }

    $this->itemModel = new ItemModel();


    $businessIdBytes = uuid_to_bytes($this->businessId);

    $post = $this->request->getPost();

    $transaction = [
      'id' => Uuid::uuid4(),
      'business_id' => $this->businessId,
      'contact_id' => ($post['contact_id']) ? uuid_to_bytes($post['contact_id']) : null,
      'number' => strval(Time::now()->timestamp),
      'due_date' => date('Y-m-d', new Time($post['due_date'])->timestamp),
      'total' => 0,
      'payment_method' => $post['payment_method'],
      'payment_status' => $post['payment_status'],
    ];

    $productsToEdit = [];
    $recordList = [];

    foreach ($post['records'] as $record) {

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
        'business_id' => $this->businessId,
        'item_id' => $item->id,
        'description' => $item->name,
        'category' => $record['category'],
        'type' => $item->type,
      ];

      $sellingPrice = (float) ($item->selling_price ?? $item->cost);

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
    $this->model = new TransactionModel();

    $this->recordModel = new RecordModel();


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
    $this->formValidator = new TransactionValidator();

    if (!$this->validate($this->formValidator->update)) {
      return redirect()->back()->withInput();
    }
    $this->model = new TransactionModel();

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
