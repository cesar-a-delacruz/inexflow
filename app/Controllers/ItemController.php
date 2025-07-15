<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Item;
use App\Models\CategoryModel;
use App\Models\ItemModel;
use App\Validation\Validators\ItemValidator;
use Ramsey\Uuid\Uuid;

class ItemController extends BaseController
{
  protected ItemModel $model;
  protected CategoryModel $category_model;
  protected ItemValidator $form_validator;
  public function __construct() {
    $this->model = new ItemModel();
    $this->category_model = new CategoryModel();
    $this->form_validator = new ItemValidator();

    helper('form');
    helper('session');
  }

  public function index()
  {
    $current_page = session()->get('current_page');
    if (is_admin() && $current_page) return redirect()->to($current_page);

    if (!user_logged()) return redirect()->to('/');
    else session()->set('current_page', 'items');

    $data['title'] = 'Items';
    $data['items'] = $this->model->findAllWithCategory(session()->get('business_id'));
    return view('Item/index', $data);
  }
  public function new()
  {
    $current_page = session()->get('current_page');
    if (is_admin() && $current_page) return redirect()->to($current_page);

    if (!user_logged()) return redirect()->to('/');
    else session()->set('current_page', 'items/new');
    
    $categories = $this->category_model->getByBusiness(uuid_to_bytes(session()->get('business_id')));
    $data = [
        'title' => 'Nuevo Item',
        'categories' => $categories  
    ];
    return view('Item/new', $data);
  }  
  public function show($id = null)
  {
    $current_page = session()->get('current_page');
    if (is_admin() && $current_page) return redirect()->to($current_page);

    if (!user_logged()) return redirect()->to('/');
    else session()->set('current_page', "items/$id");

    $item = $this->model->find(uuid_to_bytes($id));
    $categories = $this->category_model->getByBusiness(uuid_to_bytes(session()->get('business_id')));

    $data = [
        'title' => 'Editar Item',
        'item' => $item,
        'categories' => $categories
    ];
    return view('Item/show', $data);
  }

  public function create()
  {
    $item = $this->request->getPost(
      ['name', 'type', 'category_number', 'cost',
      'selling_price', 'current_stock', 'min_stock', 'measure_unit']
    );

    if (!$this->validate($this->form_validator->newRules())) {
      return redirect()->back()->withInput();
    }

    $item['id'] = Uuid::uuid4();
    $item['business_id'] = uuid_to_bytes(session()->get('business_id'));

    $this->model->insert(new Item($item));
    return redirect()->to('items/new')->with('success', 'Item insertado exitosamente.');
  }
  public function delete($id = null)
  {
    $this->model->delete(uuid_to_bytes($id));
    return redirect()->to('items');
  }
  public function update($id = null)
  {
    $post = $this->request->getPost(
      ['name', 'type', 'category_number', 'cost',
      'selling_price', 'current_stock', 'min_stock', 'measure_unit']
    );
    $row = [];
    foreach ($post as $key => $value) {
      if ($value) $row[$key] = $value;
    }
    if (empty($row)) return redirect()->to('items');

    if (!$this->validate($this->form_validator->showRules())) {
      return redirect()->back()->withInput(); 
    }

    $this->model->update(uuid_to_bytes($id), new Item($row));
    return redirect()->to('items');
  }
}
