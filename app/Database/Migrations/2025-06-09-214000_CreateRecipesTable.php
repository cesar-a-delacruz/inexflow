<?php

namespace App\Database\Migrations;

use App\Database\EntityMigration;

class CreateRecipesTable extends EntityMigration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'SERIAL',
            ],
            'product_id' => [
                'type'       => 'BIGINT',
                'unsigned' => true,
                'null'       => false,
            ],
            'ingredient_id' => [
                'type'       => 'BIGINT',
                'unsigned' => true,
                'null'       => false,
            ],
            'measure_unit_id' => [
                'type'       => 'BIGINT',
                'unsigned' => true,
                'null'       => false,
            ],
            'quantity' => [
                'type'       => 'SMALLINT',
                'unsigned' => true,
                'null'       => false,
            ],
        ]);

        parent::tenantFields();
        parent::auditableFields();

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('product_id', 'items', 'id');
        $this->forge->addForeignKey('ingredient_id', 'items', 'id');
        $this->forge->addForeignKey('measure_unit_id', 'measure_units', 'id');
        $this->forge->createTable('recipes');
    }

    public function down()
    {
        $this->forge->dropTable('recipes');
    }
}
