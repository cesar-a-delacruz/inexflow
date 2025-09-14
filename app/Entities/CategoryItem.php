<?php

namespace App\Entities;

use App\Entities\AuditableEntity;

class CategoryItem extends AuditableEntity
{
    protected $casts = [
        'category_id' => 'int',
        'item_id' => 'int',
    ];
}
