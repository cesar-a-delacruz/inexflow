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

    /** Busca todos los contactos por su negocio
     * @return array<Contact>
     */
    public function findAllByBusiness(string $business_id): array
    {
        return $this->where('business_id', uuid_to_bytes($business_id))->findAll();
    }
}
