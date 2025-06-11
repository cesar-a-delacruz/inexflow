<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBusinessesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'       => 'BINARY',
                'constraint'       => 16,
                'null'       => false,
            ],
            'business_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'owner_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'owner_email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'owner_phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default'    => 'active',
                'null'       => false,
            ],
            'registered_by' => [
                'type'       => 'BINARY',
                'constraint' => 16,
                'null'       => false,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => false,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => false,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('status', false, false, 'idx_status');
        $this->forge->addUniqueKey('owner_email', 'idx_owner_email');
        $this->forge->addForeignKey('registered_by', 'users', 'id', 'CASCADE', 'RESTRICT');

        $this->forge->createTable('businesses');
    }

    public function down()
    {
        $this->forge->dropTable('businesses');
    }
}
