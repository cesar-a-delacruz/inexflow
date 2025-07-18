<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Business;

class BusinessModel extends Model
{
    protected $table = 'businesses';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false;
    protected $returnType = Business::class;
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'id',
        'name',
        'phone',
        'owner_id',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
}
