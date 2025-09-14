<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class CategoryItem extends Entity
{
    protected $casts = [
        'category_id' => 'int',
        'item_id' => 'int',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
        'deleted_at'  => '?datetime'
    ];
}
