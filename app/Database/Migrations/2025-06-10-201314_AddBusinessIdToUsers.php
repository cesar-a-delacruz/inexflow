<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBusinessIdToUsers extends Migration
{
    public function up()
    {
        // Agregar columna business_id
        $this->forge->addColumn('users', [
            'business_id' => [
                'type'       => 'BINARY',
                'constraint'       => 16,
                'null'       => true,
                'after'      => 'role'
            ],
        ]);

        // Agregar foreign key
        $this->forge->addForeignKey('business_id', 'businesses', 'id', 'CASCADE', 'RESTRICT', 'users_business_id_foreign');
    }

    public function down()
    {
        // // Eliminar foreign key
        // $this->forge->dropForeignKey('users', 'users_business_id_foreign');

        // // Eliminar unique key
        // $this->forge->dropKey('users', 'uk_business_email');

        // // Eliminar columna
        // $this->forge->dropColumn('users', 'business_id');
    }
}
