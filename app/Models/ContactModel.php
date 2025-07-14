<?php

namespace App\Models;

use App\Entities\Contact;
use CodeIgniter\Model;

class ContactModel extends Model
{
    protected $table = 'contacts';
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
        'type'
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
    ];

    protected $skipValidation = false;
    
    public function findAllByBusiness($id) {
        return $this->where('business_id', uuid_to_bytes($id))->findAll();
    }
}
