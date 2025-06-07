<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterPlatformAdmins extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('platform_admins', [
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['admin', 'businessman'],
                'default' => 'businessman',
                'null' => false
            ]
        ]);
        $this->forge->renameTable('platform_admins', 'app_user');
    }

    public function down()
    {
        $fields = [
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['super_admin', 'platform_admin', 'support'],
                'default' => 'support',
                'null' => false
            ]
        ];
        $this->forge->modifyColumn('app_user', $fields);
        $this->forge->renameTable('app_user', 'platform_admins');
    }
}
