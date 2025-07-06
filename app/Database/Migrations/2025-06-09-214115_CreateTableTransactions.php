<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use PhpParser\Node\Expr\List_;

class CreateTableTransactions extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'null'           => false,
                'auto_increment' => true
            ],
            'business_id' => [
                'type'       => 'BINARY',
                'constraint'       => 16,
                'null'       => false,
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

        $this->forge->addKey('id', true);

        // Índices para reportes
        $this->forge->addKey(['business_id', 'transaction_date'], false, false, 'idx_business_date');
        $this->forge->addKey(['business_id', 'category_number'], false, false, 'idx_business_category');

        $this->forge->addForeignKey(
            ['business_id', 'category_number'], 'categories', ['business_id', 'category_number'],
            'CASCADE', 'RESTRICT', 'fk_category'
        );
        $this->forge->createTable('transactions');
    }

    public function down()
    {
        $this->forge->dropTable('transactions');
    }
}
