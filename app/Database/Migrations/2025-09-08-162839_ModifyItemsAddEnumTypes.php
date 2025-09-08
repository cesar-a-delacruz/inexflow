<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyItemsAddEnumTypes extends Migration
{
    public function up()
    {
        $this->db->query("
            alter table items modify type enum('product', 'service', 'ingredients','supplies') default 'product' not null;");
    }

    public function down()
    {
        $this->db->query("
            alter table items modify type enum('product', 'service') default 'product' not null;");
    }
}
