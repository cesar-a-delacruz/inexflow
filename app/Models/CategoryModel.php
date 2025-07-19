<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Category;

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

    /** Busca todos las categorías por su negocio
     * @return array<Contact>
     */
    public function findAllByBusiness(string $business_id): array
    {
        return $this->where('business_id', uuid_to_bytes($business_id))->orderBy('type', 'ASC')->findAll();
    }

    /** Verifica si el conteo de categorías en el negocio y que tengan el nombre brindado es mayor a 0 */
    public function nameExists(string $business_id, string $name): bool
    {
        return $this->where('name', $name)->where('business_id', uuid_to_bytes($business_id))->countAllResults() > 0;
    }
}
