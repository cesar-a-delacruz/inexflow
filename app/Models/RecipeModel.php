<?php

namespace App\Models;

use App\Entities\Recipe;
use App\Models\AuditableModel;

class RecipeModel extends AuditableModel
{
    protected $table = 'recipes';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = Recipe::class;

    protected $allowedFields = [
        'id',
        'business_id',
        'product_id',
        'ingredient_id',
        'measure_unit_id',
        'quantity',
    ];
}
