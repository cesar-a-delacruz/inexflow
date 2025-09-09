<?php

namespace App\Database\Migrations;

use App\Database\EntityMigration;

class CreateTableRecords extends EntityMigration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'SERIAL',
            ],
            'product_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => false,
            ],
            'transaction_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => false,
            ],
            'unit_price' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => false,
            ],
            'quantity' => [
                'type'       => 'SMALLINT',
                'unsigned' => true,
                'null'       => false,
            ],
            'subtotal' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => false,
            ],
        ]);

        parent::tenetFields();
        parent::auditableFields();

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('transaction_id', 'transactions', 'id');
        $this->forge->addForeignKey('product_id', 'items', 'id');
        $this->forge->createTable('records');
    }

    public function down()
    {
        $this->forge->dropTable('records');
    }
}
