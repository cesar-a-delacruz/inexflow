<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Categories;
use App\Models\{BusinessModel, CategoriesModel};
use CodeIgniter\HTTP\ResponseInterface;
use Ramsey\Uuid\Uuid;

class CategoryController extends BaseController
{
    protected CategoriesModel $model;
    protected BusinessModel $business_model;
    public function __construct() {
        $this->model = new CategoriesModel();
        $this->business_model = new BusinessModel();
        helper('url');
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
        $post = (object) $this->request->getPost(['category_number', 'business_id','name', 'type']);
        $post->business_id = Uuid::fromString($post->business_id)->getBytes();

        if ($this->model->categoryNumberExists($post->business_id,$post->category_number)) {
            return redirect()->back()->withInput()->with('error', 'El número de categoría ya está en uso.');
        }
        
        if ($this->model->CategoriesNameExists($post->business_id,$post->name)){
            return redirect()->back()->withInput()->with('error','El nombre de la categoria ya existe en el negocio');
        }
        
        
        // Crear entidad
        $category = new Categories([
            'business_id' => $post->business_id,
            'category_number' => $post->category_number,
            'name' => $post->name,
            'type' => $post->type,
            'is_active' => 1, // 1 representa que esta activo 
        ]);

       
        try {
            $this->model->createCategories($category);
            return redirect()->to('categories/new')->with('success', 'Categoría creada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error',  $e->getMessage());
        }
    }
}
