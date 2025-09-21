<?php

namespace App\Models;

use App\Entities\Recipe;
use App\Models\EntityModel;

/**
 * @extends EntityModel<Recipe>
 */
class RecipeModel extends EntityModel
{
    protected $table = 'recipes';
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
