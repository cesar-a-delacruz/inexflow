<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Customer;

class CustomerModel extends Model
{
    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false;
    protected $returnType = Customer::class;
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'id',
        'business_id',
        'name',
        'email',
        'phone',
        'address',
        'tax_id',
        'is_active'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [
        'business_id' => 'required',
        'name' => 'required|max_length[255]',
        'email' => 'permit_empty|valid_email|max_length[255]',
        'phone' => 'permit_empty|max_length[50]',
        'tax_id' => 'permit_empty|max_length[50]',
        'is_active' => 'required|in_list[0,1]'
    ];

    protected $validationMessages = [
        'business_id' => [
            'required' => 'El ID del negocio es requerido'
        ],
        'name' => [
            'required' => 'El nombre del cliente es requerido',
            'max_length' => 'El nombre no puede exceder 255 caracteres'
        ],
        'email' => [
            'valid_email' => 'El email debe tener un formato válido',
            'max_length' => 'El email no puede exceder 255 caracteres'
        ],
        'phone' => [
            'max_length' => 'El teléfono no puede exceder 50 caracteres'
        ],
        'tax_id' => [
            'max_length' => 'La cédula/RUC no puede exceder 50 caracteres'
        ],
        'is_active' => [
            'required' => 'El estado es requerido',
            'in_list' => 'El estado debe ser 0 o 1'
        ]
    ];

    protected $skipValidation = false;
}
