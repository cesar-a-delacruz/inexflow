<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PlatformAdmins extends Migration
{
    public function up()
    {
         $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'unique'=>true,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['super_admin', 'platform_admin', 'support'],
                'default' => 'support',
                'null' => false
            ],
            'is_active'=>[
                'type'=>'BOOLEAN',
                'default'=>true,
            ],
            'created_at'=>[
                'type'=>'TIMESTAMP',
            ],
            'update_at'=>[
                'type'=>'TIMESTAMP',
            ],
            'delete_at'=>[
                'type'=>'TIMESTAMP',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('platform_admins');
    }

    public function down()
    {
        $this->forge->dropTable('platform_admins');
    }
}
