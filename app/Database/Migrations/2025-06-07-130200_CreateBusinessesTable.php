<?php

namespace App\Database\Migrations;

use App\Database\EntityMigration;

class CreateBusinessesTable extends EntityMigration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'       => 'BINARY',
                'constraint'       => 16,
                'null'       => false,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ]
        ]);

        parent::auditableFields();

        $this->forge->addKey('id', true);

        $this->forge->createTable('businesses');
    }

    public function down()
    {
        $this->forge->dropTable('businesses');
    }
}
