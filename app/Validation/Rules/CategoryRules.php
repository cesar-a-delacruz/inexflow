<?php
namespace App\Validation\Rules;

use App\Entities\Category;
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

    public function unique_in_business($name) 
    {
        return !$this->model->nameExists(session()->get('business_id'), $name);
    }
}