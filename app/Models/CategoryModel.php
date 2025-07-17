<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Category;
use CodeIgniter\Database\Exceptions\DatabaseException;
use Ramsey\Uuid\UuidInterface;

class CategoryModel extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Category::class;
    protected $useSoftDeletes   = true;

    protected $allowedFields    = [
        'business_id',
        'number',
        'name',
        'type',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    
    public function findAllByBusiness($business_id): array
    {
        return $this->where('business_id', uuid_to_bytes($business_id))->orderBy('type', 'ASC')->findAll();
    }

    public function nameExists($business_id, $name): bool
    {
        return $this->where('name', $name)->where('business_id', uuid_to_bytes($business_id))->countAllResults() > 0;
    }
}
