<?php

namespace App\Models;

use App\Entities\CategoryItem;
use App\Models\AuditableModel;

class CategoryItemsModel extends AuditableModel
{
    protected $table            = 'categories_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = CategoryItem::class;

    protected $allowedFields    = [
        'category_id',
        'item_id',
    ];
}
