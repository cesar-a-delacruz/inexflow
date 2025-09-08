<?php

namespace App\Controllers;

use App\Controllers\CRUDController;
use App\Entities\Item;
use App\Models\{ItemModel, CategoryModel};
use App\Validation\ItemValidator;
use Ramsey\Uuid\Uuid;

class ItemController extends CRUDController
{
  protected $formValidator;
  protected $categoryModel;

  public function __construct()
  {
    parent::__construct('items');
  }


  // vistas
  public function index()
  {
    $this->model = new ItemModel();

    $data = [
      'title' => 'Elementos',
      'items' => $this->model->findAllWithCategory($this->businessId),
    ];

    helper('number');

    return view('Item/index', $data);
  }

  public function new()
  {
    $this->categoryModel = new CategoryModel();

    $data = [
      'title' => 'Nuevo Elemento',
      'categories' => $this->categoryModel->findAllByBusiness($this->businessId),
    ];


    return view('Item/new', $data);
  }

  public function show($id = null)
  {
    $this->model = new ItemModel();
    $this->categoryModel = new CategoryModel();

    $data = [
      'title' => 'Editar Elemento',
      'item' => $this->model->find(uuid_to_bytes($id)),
      'categories' => $this->categoryModel->findAllByBusiness($this->businessId),
    ];

    return view('Item/show', $data);
  }

  // acciones
  public function create()
  {
    $this->formValidator = new ItemValidator();

    if (!$this->validate($this->formValidator->create)) {
      return redirect()->back()->withInput();
    }

    $this->model = new ItemModel();

    $post = $this->request->getPost();
    $post['id'] = Uuid::uuid4();
    $post['business_id'] = uuid_to_bytes($this->businessId);

    $this->model->insert(new Item($post));

    return redirect()->to('items/new')->with('success', 'Elemento creado exitosamente.');
  }

  public function update($id = null)
  {
    $this->formValidator = new ItemValidator();

    if (!$this->validate($this->formValidator->update)) {
      return redirect()->back()->withInput();
    }

    $post = $this->request->getPost();
    $row = [];

    foreach ($post as $key => $value) {
      if ($value && $key !== '_method') $row[$key] = $value;
    }

    if (empty($row)) return redirect()->to('items');

    $this->model = new ItemModel();

    $this->model->update(uuid_to_bytes($id), new Item($row));

    return redirect()->to('items')->with('success', 'Elemento actualizado exitosamente');
  }

  public function delete($id = null)
  {
    $this->model = new ItemModel();

    if ($this->model->delete(uuid_to_bytes($id))) {
      return redirect()->to('items')->with('success', 'Elemento eliminado exitosamente');
    } else {
      return redirect()->to('items')->with('error', 'No se pudo eliminar el Elemento');
    }
  }
}
