<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableTransactions extends Migration
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
                'null'     => true,  // Cambiado a true para consistencia con SET NULL
            ],
            'category_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
            ],
            'amount' => [
                'type'       => 'DECIMAL',
                'constraint' => [10,2],
                'null'       => false,
            ],
            'description' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'transaction_date' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'payment_method' => [
                'type'       => 'ENUM',
                'constraint' => ['cash', 'card', 'transfer'],
                'default'    => 'cash',
                'null'       => false,
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,  // Especificado explícitamente
            ],
            'created_by' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,  // Cambiado a true para consistencia con SET NULL
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'null'    => false,
            ],
            'updated_at' => [
                'type'      => 'TIMESTAMP',
                'null'      => false,
            ],
        ]);

        // Agregar índices
        $this->forge->addKey('id', true);
        $this->forge->addKey('business_id');
        $this->forge->addKey('category_id');
        $this->forge->addKey('created_by');
        $this->forge->addKey('transaction_date');  // Útil para consultas por fecha

        // Agregar claves foráneas
        $this->forge->addForeignKey('business_id', 'businesses', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('category_id', 'categories', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('created_by', 'users', 'id', 'SET NULL', 'CASCADE');

        $this->forge->createTable('transactions', true);

        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->dropTable('transactions', true);
        $this->db->enableForeignKeyChecks();
    }
}