<?php

namespace App\Database\Migrations;

use App\Database\EntityMigration;

class CreateContactsTable extends EntityMigration
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
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'address' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['customer', 'provider'],
                'default' => 'customer',
                'null'       => false,
            ],
        ]);
        parent::tenetFields();
        parent::auditableFields();

        $this->forge->addKey('id', true);

        $this->forge->createTable('contacts');
    }

    public function down()
    {
        $this->forge->dropTable('contacts');
    }
}
