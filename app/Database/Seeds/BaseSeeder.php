<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BaseSeeder extends Seeder
{
    public function run()
    {
        new UserSeeder($this->config)->run();
        new BusinessSeeder($this->config)->run();
        new CategorySeeder($this->config)->run();
        new ItemsSeeder($this->config)->run();
        new ContactsSeeder($this->config)->run();
        new TransactionsSeeder($this->config)->run();
        new RecordsSeeder($this->config)->run();
    }
}
