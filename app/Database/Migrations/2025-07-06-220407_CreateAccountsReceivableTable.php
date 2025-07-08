<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAccountsReceivableTable extends Migration
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
            'contact_id' => [
                'type'       => 'BINARY',
                'constraint' => 16,
                'null'       => false,
            ],
            'invoice_id' => [
                'type'       => 'BINARY',
                'constraint' => 16,
                'null'       => false,
            ],
            'original_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => false,
            ],
            'paid_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0.00,
                'null'       => false,
            ],
            'balance_due' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => false,
            ],
            'due_date' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['current', 'overdue', 'paid'],
                'default'    => 'current',
                'null'       => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey(['business_id', 'status'], false, false, 'idx_business_status');
        $this->forge->addKey(['business_id', 'due_date'], false, false, 'idx_business_due_date');
        $this->forge->addKey(['business_id', 'contact_id'], false, false, 'idx_business_contect');
        $this->forge->addUniqueKey(['business_id', 'invoice_id'], 'uk_business_invoice');

        $this->forge->addForeignKey('business_id', 'businesses', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('contact_id', 'contects', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('invoice_id', 'invoices', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('accounts_receivable');
    }

    public function down()
    {
        $this->forge->dropTable('accounts_receivable');
    }
}
