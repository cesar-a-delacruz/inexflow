<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Item;
use App\Models\{ItemModel, CategoryModel};
use App\Validation\ItemValidator;
use Ramsey\Uuid\Uuid;

class ItemController extends BaseController
{
  protected $model;
  protected $formValidator;
  protected $categoryModel;

  public function __construct()
  {
    $this->model = new ItemModel();
    $this->formValidator = new ItemValidator();
    $this->categoryModel = new CategoryModel();
  }

  // vistas
  public function index()
  {
    if (!session()->get('business_id')) return redirect()->to('business/new');
    $redirect = check_user('businessman');
    if ($redirect !== null) return redirect()->to($redirect);
    else session()->set('current_page', 'items');

    $data = [
      'title' => 'Elementos',
      'items' => $this->model->findAllWithCategory(session()->get('business_id')),
    ];
    helper('number');

    return view('Item/index', $data);
  }

  public function new()
  {
    if (!session()->get('business_id')) return redirect()->to('business/new');
    $redirect = check_user('businessman');
    if ($redirect !== null) return redirect()->to($redirect);
    else session()->set('current_page', 'items/new');

    $data = [
      'title' => 'Nuevo Item',
      'categories' => $this->categoryModel->findAllByBusiness(session()->get('business_id')),
    ];
    return view('Item/new', $data);
  }

  public function show($id = null)
  {
    if (!session()->get('business_id')) return redirect()->to('business/new');
    $redirect = check_user('businessman');
    if ($redirect !== null) return redirect()->to($redirect);
    else session()->set('current_page', "items/$id");

    $data = [
      'title' => 'Editar Item',
      'item' => $this->model->find(uuid_to_bytes($id)),
      'categories' => $this->categoryModel->findAllByBusiness(session()->get('business_id')),
    ];
    return view('Item/show', $data);
  }

  // acciones
  public function create()
  {
    if (!$this->validate($this->formValidator->create)) {
      return redirect()->back()->withInput();
    }

    $post = $this->request->getPost();
    $post['id'] = Uuid::uuid4();
    $post['business_id'] = uuid_to_bytes(session()->get('business_id'));

    $this->model->insert(new Item($post));
    return redirect()->to('items/new')->with('success', 'Item creado exitosamente.');
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
    if (empty($row)) return redirect()->to('items');

    $this->model->update(uuid_to_bytes($id), new Item($row));
    return redirect()->to('items')->with('success', 'Item actualizado exitosamente.');
  }

  public function delete($id = null)
  {
    if ($this->model->delete(uuid_to_bytes($id))) {
      return redirect()->to('items')->with('success', 'Item eliminado exitosamente.');
    } else {
      return redirect()->to('items')->with('error', 'No se pudo eliminar el item.');
    }
  }
}
