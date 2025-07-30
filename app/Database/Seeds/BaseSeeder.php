<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/** Ejecuta todos los Seeders de manera secuencial. */
class BaseSeeder extends Seeder
{
    public function run()
    {
        new UsersSeeder($this->config)->run();
        new BusinessesSeeder($this->config)->run();
        new CategoriesSeeder($this->config)->run();
        new ItemsSeeder($this->config)->run();
        new ContactsSeeder($this->config)->run();
        new TransactionsSeeder($this->config)->run();
        new RecordsSeeder($this->config)->run();
    }
}
