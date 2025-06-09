<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableCategories extends Migration
{
    public function up()
    {
        $this->db->disableForeignKeyChecks();

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'business_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['income', 'expense'],
            ],
            'is_active' => [
                'type'    => 'BOOLEAN',
                'default' => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('business_id', 'businesses', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('categories', true);

        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
         $this->forge->dropTable('categories', true);
    }
}
