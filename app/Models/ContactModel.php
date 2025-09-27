<?php

namespace App\Models;

use App\Entities\Contact;
use App\Enums\ContactType;
use App\Models\EntityModel;

/**
 * @extends EntityModel<Contact>
 */
class ContactModel extends EntityModel
{
    protected $table = 'contacts';
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
    public function findAllByBusinessIdAndType(string $businessId, ContactType $type): array
    {
        return $this
            ->where('business_id', uuid_to_bytes($businessId))
            ->where('type', $type->value)
            ->findAll();
    }
}
