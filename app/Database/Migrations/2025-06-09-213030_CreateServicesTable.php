<?php

namespace App\Database\Migrations;

use App\Database\EntityMigration;

class CreateServicesTable extends EntityMigration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'       => 'SERIAL',
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'type' => [
                'type'    => 'ENUM',
                'constraint' => ['income', 'expense'],
                'default'    => 'expense',
                'null'    => false,
            ],
            'cost' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0.00,
                'null'       => false,
            ],
            'selling_price' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
            ],
            'measure_unit_id' => [
                'type'       => 'BIGINT',
                'unsigned' => true,
                'null'       => false,
            ],
        ]);

        parent::tenantFields();
        parent::auditableFields();

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('measure_unit_id', 'measure_units', 'id');

        $this->forge->createTable('services');
    }

    public function down()
    {
        $this->forge->dropTable('services');
    }
}
