<?php

namespace App\Models;

use App\Entities\Business;
use App\Models\AuditableModel;

class BusinessModel extends AuditableModel
{
    protected $table = 'businesses';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false;
    protected $returnType = Business::class;

    protected $allowedFields = [
        'id',
        'name',
        'phone',
    ];
}
