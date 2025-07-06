<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyTransactionsAddInvoiceId extends Migration
{
    public function up()
    {
        $this->forge->addColumn('transactions', [
            'invoice_id' => [
                'type'       => 'BINARY',
                'constraint' => 16,
                'null'       => true,
            ],
        ]);

        $this->db->query('
            ALTER TABLE `transactions`
            ADD CONSTRAINT `fk_transactions_invoice_id`
            FOREIGN KEY (`invoice_id`) REFERENCES `invoices`(`id`)
            ON DELETE SET NULL
            ON UPDATE CASCADE
        ');
    }

    public function down()
    {
        $this->db->query('
            ALTER TABLE `transactions`
            DROP FOREIGN KEY `fk_transactions_invoice_id`
        ');

        $this->forge->dropColumn('transactions', 'invoice_id');
    }
}
