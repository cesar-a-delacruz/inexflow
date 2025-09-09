<?php

namespace App\Database;

use CodeIgniter\Database\Migration;

abstract class EntityMigration extends Migration
{

    protected function auditableFields()
    {
        $this->forge->addField([
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => false,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => false,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
    }
    protected function tenetFields()
    {
        $this->forge->addField([
            'business_id' => [
                'type' => 'BINARY',
                'constraint' => 16,
                'null' => true,
            ],
        ]);
        $this->forge->addForeignKey('business_id', 'businesses', 'id');
    }
}
