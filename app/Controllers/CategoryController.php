<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Category;
use App\Models\{CategoryModel, BusinessModel};
use App\Validation\CategoryValidator;

class CategoryController extends BaseController
{
    protected $model;
    protected $formValidator;
    protected $businessModel;
    
    public function __construct() 
    {
        $this->model = new CategoryModel();
        $this->formValidator = new CategoryValidator();
        $this->businessModel = new BusinessModel();
    }

    // vistas
    public function index()
    {
        if (!session()->get('business_id')) return redirect()->to('business/new');
        $redirect = check_user('businessman');
        if ($redirect !== null) return redirect()->to($redirect);
        else session()->set('current_page', 'categories');

        $data = [
            'title' => 'Categorías de Items',
            'categories' => $this->model->findAllByBusiness(uuid_to_bytes(session()->get('business_id')))  
        ];
        return view('Category/index', $data);
    }

    public function new()
    {
        if (!session()->get('business_id')) return redirect()->to('business/new');
        $redirect = check_user('businessman');
        if ($redirect !== null) return redirect()->to($redirect);
        else session()->set('current_page', 'categories/new');
        
        $businesses = $this->businessModel->findAll();
        $data = [
            'title' => 'Nueva Categoría',
            'businesses' => $businesses  
        ];
        return view('Category/new', $data);
    }

    public function show($id = null)
    {
        if (!session()->get('business_id')) return redirect()->to('business/new');
        $redirect = check_user('businessman');
        if ($redirect !== null) return redirect()->to($redirect);
        else session()->set('current_page', "categories/$id");

        $data = [
            'title' => 'Editar Item',
            'category' => $this->model->find($id),
        ];
        return view('Category/show', $data);
    }

    // acciones
    public function create()
    {
        if (!$this->validate($this->formValidator->create)) {
            return redirect()->back()->withInput();
        }
        $post = $this->request->getPost();
        $post['business_id'] = uuid_to_bytes(session()->get('business_id'));

        $this->model->insert(new Category($post));
        return redirect()->to('categories/new')->with('success', 'Categoría creada exitosamente.');
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
        if (empty($row)) return redirect()->to('categories');

        $this->model->update($id, new Category($row));
        return redirect()->to('categories')->with('success', 'Categoría actualizada exitosamente.');
    }

    public function delete($id)
    {
        if ($this->model->delete($id)) {
            return redirect()->to('categories')->with('success', 'Categoría eliminada exitosamente.');
        } else {
            return redirect()->to('categories')->with('error', 'No se pudo eliminar la categoríia.');
        }
    }
}
