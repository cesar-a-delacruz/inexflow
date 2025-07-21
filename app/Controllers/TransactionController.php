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
    return view('Transaction/index', $data);
  }

  public function new()
  {
    $businessId = session()->get('business_id');

    if (!$businessId) return redirect()->to('business/new');
    $redirect = check_user('businessman');
    if ($redirect !== null) return redirect()->to($redirect);
    else session()->set('current_page', 'transactions/new');

    $items = $this->itemModel->findAllWithCategory($businessId);
    $items = (function ($array) {
      $income = [];
      $expense = [];

      foreach ($array as $item) {
        if ($item->category_type === 'income') array_push($income, $item);
        else array_push($expense, $item);
      }

      return (object) ['income' => $income, 'expense' => $expense];
    })($items);
    $contacts = $this->contactModel->findAllByBusiness(session()->get('business_id'));
    $contacts = (function ($array) {
      $customer = [];
      $provider = [];

      foreach ($array as $contact) {
        if ($contact->type === 'customer') array_push($customer, $contact);
        else array_push($provider, $contact);
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


    $post = $this->request->getPost();

    $stockValidation = $this->validateStock($post['records'], $businessId);
    if (!is_array($stockValidation)) {
      $validation = \Config\Services::validation();
      $validation->setError('stock', $stockValidation);

      return redirect()->back()->withInput();
    }

    $post['id'] = Uuid::uuid4();
    $post['business_id'] = uuid_to_bytes($businessId);
    $post['contact_id'] = ($post['contact_id']) ? uuid_to_bytes($post['contact_id']) : null;
    $post['number'] = strval(Time::now()->timestamp);
    $post['due_date'] = date('Y-m-d', new Time($post['due_date'])->timestamp);

    $records = [];
    foreach ($post['records'] as $record) {
      $record['transaction_id'] = $post['id'];
      $record['business_id'] = $post['business_id'];
      if (!isset($record['amount'])) $record['amount'] = null;
      array_push($records, new Record($record));
    }

    $this->model->insert(new Transaction($post));
    $this->recordModel->insertBatch($records);

    foreach ($stockValidation as $item) {
      $this->itemModel->update(uuid_to_bytes(($item['id'])), ['stock' => $item['stock']]);
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

  private function validateStock(array $records, string $businessId): array|string
  {
    $businessIdBytes = uuid_to_bytes($businessId);
    $items = [];
    foreach ($records as $index => $record) {
      if (!isset($record['amount']) || empty($record['amount'])) {
        continue;
      }

      $amount = (int)$record['amount'];
      $itemId = $record['item_id'] ?? null;

      if (!$itemId) {
        return "Error en el registro #" . ($index + 1) . ": No se especificó el producto.";
      }

      $item = $this->itemModel->where('business_id', $businessIdBytes)->find(uuid_to_bytes($itemId));

      if (!$item) {
        return "Error en el registro #" . ($index + 1) . ": Producto no encontrado.";
      }

      if ($item->type !== 'product') continue;

      if ($item->stock < $amount) {
        return "Error en el registro #" . ($index + 1) . ": Stock insuficiente para '{$item->name}'. Disponible: {$item->stock}, Solicitado: {$amount}.";
      }

      array_push($items, [
        'id' => uuid_to_bytes($item->id),
        'stock' => $item->stock - $amount,
      ]);
    }

    return $items;
  }
}
