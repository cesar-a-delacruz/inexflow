<?php

namespace App\Database\Seeds;

use App\Entities\Contact;
use App\Enums\ContactType;
use App\Models\ContactModel;
use CodeIgniter\Database\Seeder;
use Ramsey\Uuid\Uuid;

class ContactsSeeder extends Seeder
{
    public function run()
    {
        $model = new ContactModel();
        $model->insert(new Contact([
            'business_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'name' => 'César De La Cruz',
            'email' => 'cesar.delacruz@email.com',
            'phone' => '66778899',
            'address' => 'El Cuadrante',
            'type' => ContactType::Customer,
        ]));
        $model->insert(new Contact([
            'business_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'name' => 'Ericka Abrego',
            'email' => 'ericka.abrego@email.com',
            'phone' => '66778899',
            'address' => 'Finca 11',
            'type' => ContactType::Customer,
        ]));
        $model->insert(new Contact([
            'business_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'name' => 'Vende Pollos S.A.',
            'email' => 'vende.pollo@email.com',
            'phone' => '87325655',
            'address' => 'Finca 4',
            'type' => ContactType::Provider,
        ]));
    }
}
