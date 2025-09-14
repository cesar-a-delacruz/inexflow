<?php

namespace App\Database\Migrations;

use App\Database\EntityMigration;

class CreateCategoriesTable extends EntityMigration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'SERIAL',
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
        ]);

        parent::tenantFields();
        parent::auditableFields();

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['business_id', 'name']);

        $this->forge->createTable('categories');
    }

    public function down()
    {
        $this->forge->dropTable('categories');
    }
}
