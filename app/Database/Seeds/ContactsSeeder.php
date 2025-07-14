<?php

namespace App\Database\Seeds;

use App\Entities\Contact;
use App\Models\ContactModel;
use CodeIgniter\Database\Seeder;
use Ramsey\Uuid\Uuid;

class ContactsSeeder extends Seeder
{
    public function run()
    {
        $model = new ContactModel();
        $model->insert(new Contact([
            'id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'business_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'name' => 'César De La Cruz',
            'email' => 'cesar.delacruz@email.com',
            'phone' => '66778899',
            'address' => 'El Cuadrante',
            'type' => 'customer',
        ]));
        $model->insert(new Contact([
            'id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '2'),
            'business_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'name' => 'Antonio Chávez',
            'email' => 'antonio.chavez@email.com',
            'phone' => '11223344',
            'address' => 'Almirante',
            'type' => 'customer',
        ]));
        $model->insert(new Contact([
            'id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '3'),
            'business_id' => Uuid::uuid3(Uuid::NAMESPACE_URL, '1'),
            'name' => 'Distribuidor',
            'email' => 'distribuidor@email.com',
            'phone' => '55669900',
            'address' => 'David',
            'type' => 'provider',
        ]));
    }
}
