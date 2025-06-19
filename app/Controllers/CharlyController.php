<?php 

namespace App\Controllers;

use App\Models\CategoriesModel; 
use App\Models\BusinessModel;
use Ramsey\Uuid\Uuid;
use App\Entities\Categories;
class CharlyController extends BaseController{

    protected $categoriesModel;
    protected $businessModel;
public function __construct(){
    helper('url');
    $this->categoriesModel = new CategoriesModel();
    $this->businessModel = new BusinessModel();
    
}
public function index(){

    $businesses = $this->businessModel->findAll();

      $data = [
            'title' => 'Crear Categoría',
            'businesses' => $businesses  
        ];
    return view('Category/new',$data);
}

public function createCat(){

 
        $post = (object) $this->request->getPost(['category_number', 'business_id','name', 'type']);
        $post->business_id = Uuid::fromString($post->business_id)->getBytes();

        if ($this->categoriesModel->categoryNumberExists($post->business_id,$post->category_number)) {
            return redirect()->back()->withInput()->with('error', 'El número de categoría ya está en uso.');
        }
        
        if ($this->categoriesModel->CategoriesNameExists($post->business_id,$post->name)){
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
    $this->categoriesModel->createCategories($category);
    return redirect()->to('Category/new')->with('success', 'Categoría creada exitosamente.');
} catch (\Exception $e) {
    return redirect()->back()->withInput()->with('error',  $e->getMessage());
}
       
}
}





