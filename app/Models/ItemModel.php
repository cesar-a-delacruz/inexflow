<?php

namespace App\Models;

use App\Entities\Item;
use App\Enums\ItemType;
use App\Models\EntityModel;

/**
 * @extends EntityModel<Item>
 */
class ItemModel extends EntityModel
{
    protected $table = 'items';
    protected $returnType = Item::class;

    protected $allowedFields = [
        'id',
        'business_id',
        'name',
        'type',
        'cost',
        'selling_price',
        'stock',
        'min_stock',
        'measure_unit_id',
    ];

    /** Busca todos los items con su categoría asociada por su negocio
     * @return array<Item>
     */
    public function findAllWithCategory(string $business_id): array
    {
        return $this
            ->select('items.*, c.name as category_name, c.type as category_type')
            ->where('items.business_id', uuid_to_bytes($business_id))
            ->where("((items.type = 'product' AND items.stock > 0 ) OR items.type = 'service')")
            ->join('categories c', 'c.business_id = items.business_id AND c.id = items.category_id')
            ->findAll();
    }
    /** 
     * @return array<Item>
     */
    public function findAllByBusinessId(string $businessId): array
    {
        return $this
            ->where('business_id', uuid_to_bytes($businessId))
            ->findAll();
    }
    /** 
     * @return array<Item>
     */
    public function findAllByBusinessIdAndType(string $businessId, ItemType $type): array
    {
        return $this
            ->select('items.*, mu.value as measure_unit_value')
            ->where('business_id', uuid_to_bytes($businessId))
            ->where('type', $type->value)
            ->join('measure_units mu', 'mu.id = items.measure_unit_id')
            ->findAll();
    }
}
