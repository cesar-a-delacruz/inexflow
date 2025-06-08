<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBusinessesTable extends Migration
{
    public function up()
    {
        $this->db->disableForeignKeyChecks();

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'business_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'owner_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'owner_email' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'owner_phone' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'tax_id' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'comment' => 'NIT/RUC',
            ],
            'address' => [
                'type' => 'TEXT',
            ],
            'logo_url' => [
                'type' => 'VARCHAR',
                'constraint' => '500'
            ],
            'onboarding_completed' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive', 'suspended'],
                'default'    => 'active',
            ],
            'registered_by' => [
                'type' => 'INT',
                'unsigned' => true,
                'null'     => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);

        // Índice y FK a app_user.id
        $this->forge->addKey('registered_by');
        $this->forge->addForeignKey('registered_by', 'users', 'id', 'SET NULL', 'CASCADE');

        $this->forge->createTable('businesses');

        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('businesses');
    }
}
