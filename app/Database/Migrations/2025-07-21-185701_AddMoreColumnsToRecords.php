<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMoreColumnsToRecords extends Migration
{
    public function up()
    {
        $this->forge->addColumn('records', [
            'item_id' => [
                'type' => 'BINARY',
                'constraint' => 16,
                'null' => false,
                'after' => 'id'
            ],
            'unit_price' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
            ],
            'type' => [
                'type'    => 'ENUM',
                'constraint' => ['product', 'service'],
                'default'    => 'product',
                'null'    => false,
            ],
        ]);
        $this->forge->addForeignKey('item_id', 'items', 'id', 'NO ACTION', 'NO ACTION', 'records_item_id_foreign');
    }

    public function down()
    {
        $this->forge->dropForeignKey('records', 'records_item_id_foreign');
        $this->forge->dropColumn('records', 'item_id');
        $this->forge->dropColumn('records', 'unit_price');
        $this->forge->dropColumn('records', 'type');
    }
}
