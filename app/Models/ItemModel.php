<?php

namespace App\Models;

use App\Entities\Item;
use CodeIgniter\Model;

class ItemModel extends Model
{
    protected $table = 'items';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false;
    protected $returnType = Item::class;
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'id',
        'business_id',
        'category_id',
        'name',
        'type',
        'cost',
        'selling_price',
        'stock',
        'min_stock',
        'measure_unit',
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    public function findAllWithCategory($business_id): array
    {
        return $this->select('items.*, categories.name as category_name, categories.type as category_type')
        ->where('items.business_id', uuid_to_bytes($business_id))->join('categories', 'categories.id = items.category_id')->findAll();
    }
}
