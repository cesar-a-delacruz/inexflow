<?php
namespace App\Validation\Rules;

use App\Models\CategoryModel;

/**
 * Son las reglas presonalizadas de validación utilizadas en los formularios de App\Views\Category 
 */
class CategoryRules 
{
    protected $model;

    public function __construct() 
    {
        $this->model = new CategoryModel();
    }

    /** Verifica si la categoría es única en el negocio  */
    public function unique_in_business(string $name) 
    {
        return !$this->model->nameExists(session()->get('business_id'), $name);
    }
}