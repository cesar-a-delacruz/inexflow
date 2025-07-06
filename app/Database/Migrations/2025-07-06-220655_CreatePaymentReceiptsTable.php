<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePaymentReceiptsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'       => 'BINARY',
                'constraint' => 16,
                'null'       => false,
            ],
            'business_id' => [
                'type'       => 'BINARY',
                'constraint' => 16,
                'null'       => false,
            ],
            'customer_id' => [
                'type'       => 'BINARY',
                'constraint' => 16,
                'null'       => false,
            ],
            'account_receivable_id' => [
                'type'       => 'BINARY',
                'constraint' => 16,
                'null'       => true,
            ],
            'amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => false,
            ],
            'payment_method' => [
                'type'       => 'ENUM',
                'constraint' => ['cash', 'card', 'transfer', 'check'],
                'null'       => false,
            ],
            'payment_date' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'reference' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'comment'    => 'Número de cheque, transferencia'
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_by' => [
                'type'       => 'BINARY',
                'constraint' => 16,
                'null'       => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey(['business_id', 'payment_date'], false, false, 'idx_business_payment_date');
        $this->forge->addKey(['business_id', 'customer_id'], false, false, 'idx_business_customer');

        $this->forge->addForeignKey('business_id', 'businesses', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('customer_id', 'customers', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('account_receivable_id', 'accounts_receivable', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('created_by', 'users', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('payment_receipts');
    }

    public function down()
    {
        $this->forge->dropTable('payment_receipts');
    }
}
