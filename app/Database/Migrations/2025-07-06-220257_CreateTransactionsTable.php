<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'       => 'BINARY',
                'constraint' => 16,
                'null'       => false,
            ],
            'number' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
                'comment'    => 'Correlativo por negocio'
            ],
            'business_id' => [
                'type'       => 'BINARY',
                'constraint' => 16,
                'null'       => false,
            ],
            'contact_id' => [
                'type'       => 'BINARY',
                'constraint' => 16,
                'null'       => true,
                'comment'    => 'NULL para venta sin cliente'
            ],
            'payment_status' => [
                'type'       => 'ENUM',
                'constraint' => ['paid', 'pending', 'overdue', 'cancelled'],
                'default'    => 'paid',
                'null'       => false,
            ],
            'payment_method' => [
                'type'       => 'ENUM',
                'constraint' => ['cash', 'card', 'transfer'],
                'null'       => true,
            ],
            'due_date' => [
                'type' => 'DATE',
                'null' => true,
                'comment' => 'Fecha de vencimiento para crédito'
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['business_id', 'number'], 'uk_business_transaction_number');
        $this->forge->addForeignKey('business_id', 'businesses', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('contact_id', 'contacts', 'id', 'CASCADE', 'RESTRICT');
        
        $this->forge->createTable('transactions');
    }

    public function down()
    {
        $this->forge->dropTable('transactions');
    }
}
