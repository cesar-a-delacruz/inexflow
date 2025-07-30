<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBusinessIdToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'business_id' => [
                'type' => 'BINARY',
                'constraint' => 16,
                'null' => true,
            ],
        ]);

        $this->forge->addForeignKey('business_id', 'businesses', 'id', 'CASCADE', 'RESTRICT', 'users_business_id_foreign');
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'business_id');
    }
}
