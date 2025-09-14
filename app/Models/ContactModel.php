<?php

namespace App\Models;

use App\Entities\Contact;
use App\Enums\ContactType;
use App\Models\AuditableModel;

class ContactModel extends AuditableModel
{
    protected $table = 'contacts';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
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

    /** 
     * @return array<Contact>
     */
    public function findAllByBusinesIdAndType(string $businessId, ContactType $type): array
    {
        return $this
            ->where('business_id', uuid_to_bytes($businessId))
            ->where('type', $type->value)
            ->findAll();
    }
}
