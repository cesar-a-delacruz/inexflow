<?php

namespace App\Models;

use App\Entities\Service;

class ServiceModel extends AuditableModel
{
    protected $table = 'services';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = Service::class;

    protected $allowedFields = [
        'id',
        'business_id',
        'name',
        'type',
        'cost',
        'selling_price',
        'measure_unit_id',
    ];

    /** Busca todos los items con su categoría asociada por su negocio
     * @return array<Item>
     */
    public function findAllWithCategory(string $business_id): array
    {
        return $this
            ->select('services.*, c.name as category_name, c.type as category_type')
            ->where('services.business_id', uuid_to_bytes($business_id))
            ->where("((services.type = 'product' AND services.stock > 0 ) OR services.type = 'service')")
            ->join('categories c', 'c.business_id = services.business_id AND c.id = services.category_id')
            ->findAll();
    }
}
