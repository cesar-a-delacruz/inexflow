<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableTransactions extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'business_id' => [
                'type'       => 'BINARY',
                'constraint'       => 16,
                'null'       => false,
            ],
            'transaction_number' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'null'           => false,
            ],
            'category_number' => [
                'type'           => 'SMALLINT',
                'constraint'     => 5,
                'unsigned'       => true,
                'null'           => false,
            ],
            'amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
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
                'null' => true,
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

        // Primary key compuesta
        $this->forge->addKey(['business_id', 'transaction_number'], true);

        // Índices para reportes
        $this->forge->addKey(['business_id', 'transaction_date'], false, false, 'idx_business_date');
        $this->forge->addKey(['business_id', 'category_number'], false, false, 'idx_business_category');

        // Foreign keys
        $this->forge->addForeignKey('business_id', 'businesses', 'id', 'CASCADE', 'RESTRICT');

        $this->forge->createTable('transactions');

        // Foreign key compuesta para categorías
        $this->db->query('ALTER TABLE transactions ADD CONSTRAINT fk_business_category 
                         FOREIGN KEY (business_id, category_number) 
                         REFERENCES categories(business_id, category_number) 
                         ON DELETE CASCADE');
    }

    public function down()
    {
        $this->forge->dropTable('transactions');
    }
}
