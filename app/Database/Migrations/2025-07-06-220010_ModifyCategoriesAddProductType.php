<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyCategoriesAddProductType extends Migration
{
    public function up()
    {
        // Modificar el ENUM para incluir 'product'
        $this->db->query("ALTER TABLE categories MODIFY COLUMN type ENUM('income', 'expense', 'product') NOT NULL");
    }

    public function down()
    {
        $this->db->query("ALTER TABLE categories MODIFY COLUMN type ENUM('income', 'expense') NOT NULL");
    }
}
