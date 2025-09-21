<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableMeasureUnits extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'SERIAL',
            ],
            'value' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('measure_units');
    }

    public function down()
    {
        $this->forge->dropTable('measure_units');
    }
}
