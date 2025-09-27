<?php

namespace App\Models;

use App\Entities\Business;
use App\Models\EntityModel;

/**
 * @extends EntityModel<Business>
 */
class BusinessModel extends EntityModel
{
    protected $table = 'businesses';
    protected $useAutoIncrement = false;
    protected $returnType = Business::class;

    protected $allowedFields = [
        'id',
        'name',
        'phone',
    ];
}
