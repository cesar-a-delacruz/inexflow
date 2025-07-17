<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyTransactionsAddInvoiceId extends Migration
{
    public function up()
    {
        $this->forge->addColumn('records', [
            'transaction_id' => [
                'type'       => 'BINARY',
                'constraint' => 16,
                'null'       => true,
            ],
        ]);

        $this->db->query('
            ALTER TABLE `records`
            ADD CONSTRAINT `fk_records_transaction_id`
            FOREIGN KEY (`transaction_id`) REFERENCES `transactions`(`id`)
            ON DELETE SET NULL
            ON UPDATE CASCADE
        ');
    }

    public function down()
    {
        $this->db->query('
            ALTER TABLE `records`
            DROP FOREIGN KEY `fk_records_transaction_id`
        ');

        $this->forge->dropColumn('records', 'transaction_id');
    }
}
