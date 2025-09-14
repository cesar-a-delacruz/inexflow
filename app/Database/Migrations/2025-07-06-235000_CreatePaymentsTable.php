<?php

namespace App\Database\Migrations;

use App\Database\EntityMigration;

class CreatePaymentsTable extends EntityMigration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'SERIAL',
            ],
            'transaction_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => false,
            ],
            'payment_method' => [
                'type'       => 'ENUM',
                'constraint' => ['cash', 'card', 'transfer'],
                'null'       => true,
            ],
            'amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => false,
            ],
        ]);
        parent::tenantFields();
        parent::auditableFields();
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('transaction_id', 'transactions', 'id');
        $this->forge->createTable('payments');
    }

    public function down()
    {
        $this->forge->dropTable('payments');
    }
}
