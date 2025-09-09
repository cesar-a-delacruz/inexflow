<?php

namespace App\Database\Migrations;

use App\Database\EntityMigration;

class CreateUsersTable extends EntityMigration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'       => 'BINARY',
                'constraint'       => 16,
                'null' => false,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'password_hash' => [
                'type'       => 'CHAR',
                'constraint' => 60,
                'null'       => false,
            ],
            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['admin', 'businessman'],
                'default'    => 'businessman',
                'null'       => false,
            ],
            'is_active' => [
                'type'    => 'BOOLEAN',
                'default' => true,
                'null'    => false,
            ],
        ]);

        parent::tenetFields();
        parent::auditableFields();

        $this->forge->addKey('id', true);

        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
