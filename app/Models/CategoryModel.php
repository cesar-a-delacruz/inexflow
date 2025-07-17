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

    /**
     * Actualizar una categoria existente
     */
    public function updateCategories(UuidInterface|string $id, Category $categories): bool
    {
        $bytes = uuid_to_bytes($id);

        $existing = $this->find($bytes);

        if (!$existing) {
            throw new \InvalidArgumentException('Categoría no encontrada');
        }
        // Verificar si el número de categoría fue modificado
        if ($categories->category_number !== $existing->category_number && $this->categoryNumberExists($categories->category_number)) {
            throw new \InvalidArgumentException('El nuevo número de categoría ya está en uso');
        }

        try {
            return $this->update($bytes, $categories);
        } catch (\Exception $e) {
            log_message('error', 'Error actualizando categoria: ' . $e->getMessage());
            throw $e;
        }
    }
    /**
     * Verificar si una name ya existe
     */
    public function CategoriesNameExists(string $name): bool
    {
        return $this->where('name', $name)->countAllResults() > 0;
    }
    /**
     * Obtener categorías por tipo (income/expense)
     * @return array<Category>
     */
    public function getByType(string $type): array
    {
        return $this->where('type', $type)->findAll();
    }

    /**
     * Eliminar categoria (soft delete)
     */
    public function deleteCategories(UuidInterface|string $id)
    {
        $business_id = substr($id, 0, 36);
        $category_number = substr($id, 36);
        $this->where('business_id', uuid_to_bytes($business_id))
            ->where('category_number', $category_number)->delete();
    }
}
