<?php

namespace App\Models;

use App\Entities\CategoryItem;
use App\Models\AuditableModel;
/**
 * @extends EntityModel<CategoryItem>
 */
class CategoryItemsModel extends EntityModel
{
    protected $table            = 'categories_items';
    protected $returnType       = CategoryItem::class;

    protected $allowedFields    = [
        'category_id',
        'item_id',
    ];
}
