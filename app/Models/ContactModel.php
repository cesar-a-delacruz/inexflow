<?php

namespace App\Models;

use App\Entities\Contact;
use CodeIgniter\Model;

class ContactModel extends Model
{
    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false;
    protected $returnType = Contact::class;
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'id',
        'business_id',
        'name',
        'email',
        'phone',
        'address',
        'tax_id',
        'is_active',
        'is_provider'
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
        'is_active' => 'required|in_list[0,1]',
        'is_provider' => 'required|in_list[0,1]',
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
        ],
        'is_privider' => [
            'required' => 'El si es proveedor es requerido',
            'in_list' => 'El si es proveedor debe ser 0 o 1'
        ],
    ];

    protected $skipValidation = false;
}
