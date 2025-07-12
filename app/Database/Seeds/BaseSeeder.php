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
        new ItemSeeder($this->config)->run();
        new InvoiceSeeder($this->config)->run();
        new TransactionSeeder($this->config)->run();
    }
}
