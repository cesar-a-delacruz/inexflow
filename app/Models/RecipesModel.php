<?php

namespace App\Models;

use App\Entities\Recipes;
use App\Models\AuditableModel;

class RecipesModel extends AuditableModel
{
    protected $table = 'recipes';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false;
    protected $returnType = Recipes::class;

    protected $allowedFields = [
        'id',
        'business_id',
        'product_id',
        'ingredient_id',
        'measure_unit_id',
        'quantity',
    ];
}
