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

    $data['title'] = 'Productos y Servicios';
    $data['items'] = $this->model->findAllWithCategory();
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
}
