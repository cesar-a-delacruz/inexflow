<?php

namespace App\Models;

use App\Entities\Contact;
use App\Models\AuditableModel;

class ContactModel extends AuditableModel
{
    protected $table = 'contacts';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false;
    protected $returnType = Contact::class;

    protected $allowedFields = [
        'id',
        'business_id',
        'name',
        'email',
        'phone',
        'address',
        'type'
    ];


    /** Busca todos los contactos por su negocio
     * @return array<Contact>
     */
    public function findAllByBusiness(string $business_id): array
    {
        return $this->where('business_id', uuid_to_bytes($business_id))->findAll();
    }
}
