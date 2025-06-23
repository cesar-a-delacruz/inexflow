<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Categories;
use App\Models\{BusinessModel, CategoriesModel};
use App\Validation\Validators\CategoryValidator;

class CategoryController extends BaseController
{
    protected CategoriesModel $model;
    protected BusinessModel $business_model;
    protected CategoryValidator $form_validator;
    public function __construct() {
        $this->model = new CategoriesModel();
        $this->business_model = new BusinessModel();
        $this->form_validator = new CategoryValidator();

        helper('form');
        helper('session');
    }

    public function index()
    {
        $current_page = session()->get('current_page');
        if (is_admin() && $current_page) return redirect()->to($current_page);

        if (!user_logged()) return redirect()->to('/');
        else session()->set('current_page', 'categories');

        $categories = $this->model->getByBusiness(uuid_to_bytes(session()->get('business_id')));
        $data = [
            'title' => 'Categorías de Transacciones',
            'categories' => $categories  
        ];
        return view('Category/index', $data);
    }
    public function new()
    {
        $current_page = session()->get('current_page');
        if (is_admin() && $current_page) return redirect()->to($current_page);

        if (!user_logged()) return redirect()->to('/');
        else session()->set('current_page', 'categories/new');
        
        $businesses = $this->business_model->findAll();
        $data = [
            'title' => 'Crear Categoría',
            'businesses' => $businesses  
        ];
        return view('Category/new', $data);
    }

    public function create()
    {
        $category = $this->request->getPost(['category_number','name', 'type']);
        if (!$this->validate($this->form_validator->newRules())) {
            return redirect()->back()->withInput();
        }
        $category['business_id'] = uuid_to_bytes(session()->get('business_id'));

        $this->model->createCategories(new Categories($category));
        return redirect()->to('categories/new')->with('success', 'Categoría creada exitosamente.');
    }
    public function delete($id)
    {
        $this->model->deleteCategories($id);
        return redirect()->to('categories');
    }
}
