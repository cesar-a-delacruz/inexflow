<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Categories;
use CodeIgniter\Database\Exceptions\DatabaseException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class CategoriesModel extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Categories::Class;
    protected $useSoftDeletes   = true;

    // protected $protectFields    = true;
     protected $allowedFields    = [
        'business_id',
        'category_number',
        'name',
        'type',
        'is_active',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    // protected $dateFormat    = 'datetime';
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validaciones
    protected $validationRules = [
        'type'        => 'in_list[income,expense]',
        'category_number' =>'required|integer|is_unique[categories.category_number]',
        'name'            => 'required|string|max_length[255]',
        'business_id' => 'permit_empty',
        'is_active' => 'permit_empty|in_list[0,1]'
    ];

    protected $validationMessages   = [
        'type' => [
            'in_list' => 'solo puede ser income o expense'// ingresos o gastos
        ],
        'category_number' => [
            'required'   => 'El número de categoría es requerido',
            'integer'    => 'El número de categoría debe ser un entero',
            'is_unique' => 'Este número de categoría ya está registrado' 
        ],
        'name' => [
            'required'   => 'El nombre es requerido',
            'max_length' => 'El nombre no puede exceder 255 caracteres',
        ],
        'business_id' => [],
        'is_active' => [
            'in_list' => 'Solo puede estar desactivado o activado'
        ]
    ];
    protected $skipValidation = false;

    /**
     * Crear una nueva categoria con validación de Entity
     */
     public function createCategories(Categories $categories, $returnID = true): bool|int|UuidInterface
    {
        // Verificar duplicados
        if ($this->categoryNumberExists($categories->category_number)) {
            throw new \InvalidArgumentException('El número de categoría ya está registrado');
        }

         try {

            if ($categories->id === null) $categories->id = generate_uuid();

            $result = $this->insert($categories);

            if ($result === false) {
                throw new DatabaseException('Error al insertar la categoría: ' . implode(', ', $this->errors()));
            }

            if ($returnID) return $categories->id;

            return $result;
        } catch (\Exception $e) {
            log_message('error', 'Error creando categoría: ' . $e->getMessage());
            throw $e;
        }

    }
     /**
     * Actualizar una categoria existente
     */
     public function updateCategories(UuidInterface|string $id, Categories $categories): bool
    {
         $bytes = uuid_to_bytes($id);

        $existing = $this->find($bytes);

         if (!$existing) {
            throw new \InvalidArgumentException('Categoría no encontrada');
        }
        // Verificar si el número de categoría fue modificado
        if ($categories->category_number !== $existing->category_number && $this-> categoryNumberExists($categories->category_number)) {
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
     * Busca un usuario por category_num
     */
    public function findByCategory_num(string $category_num): ?Categories
    {
        return $this->where('category_num', $category_num)->first();
    }

     /**
     * Verificar si category_num ya existe
     */
    private function CategoriesCategory_numberExists(string $category_number): ?Categories
    {
        return $this->where('category_number', $category_number)->countAllResults() > 0;
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
     * @return array<Categories>
     */
    public function getByType(string $type): array
    {
        return $this->where('type', $type)->findAll();
    }
    /**
     * Obtener categorías por negocio
     * @param string|UuidInterface $businessId
     * @return array<Categories>
     */
    public function getByBusiness($businessId): array
    {
        return $this->where('business_id', $businessId)->findAll();
    }

    /**
     * Activa o desactiva una Categoria
     */
    public function toggleActive(UuidInterface|string $id): bool
    {
        $bytes = uuid_to_bytes($id);

        $categories = $this->find($bytes);

        if (!$categories) {
            return false;
        }

        return $this->update($bytes, ['is_active' => !$categories->is_active]);
    }

    /**
     * Eliminar categoria (soft delete)
     */
    public function deleteCategories(UuidInterface|string $id): bool
    {
        return $this->delete(uuid_to_bytes($id));
    }
    /**
     * Restaurar categoría eliminada
     */
    public function restoreCategories(UuidInterface|string $id): bool
    {
        return $this->update(uuid_to_bytes($id));
    }
    
    /**
     * Obtener categorías paginadas
     */
    public function getCategoriesPaginated(int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;

        $categories = $this->findAll($perPage, $offset);
        $total = $this->countAll();

        return [
            'data' => $this->findAll($perPage, $offset),
            'total' => $this->countAll(),
            'page' => $page,
            'per_page' => $perPage,
            'total_pages' => ceil($this->countAll() / $perPage)
        ];
    }

}

