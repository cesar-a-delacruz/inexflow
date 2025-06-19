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
    }

    public function new()
    {
        $businesses = $this->business_model->findAll();
        $data = [
            'title' => 'Crear Categoría',
            'businesses' => $businesses  
        ];
        return view('Category/new', $data);
    }

    public function create()
    {
        $post = $this->request->getPost(['category_number', 'business_id','name', 'type']);
        if (!$this->validate($this->form_validator->newRules())) {
            return redirect()->back()->withInput();
        }
        $post['business_id'] = uuid_to_bytes($post['business_id']);
        
        $category = new Categories($post);
        $this->model->createCategories($category);
        return redirect()->to('categories/new')->with('success', 'Categoría creada exitosamente.');
    }
}
