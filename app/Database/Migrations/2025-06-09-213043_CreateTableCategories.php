<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableCategories extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'business_id' => [
                'type'       => 'BINARY',
                'constraint' => 16,
                'null'       => false,
            ],
            'category_number' => [
                'type'           => 'SMALLINT',
                'constraint'     => 5,
                'unsigned'       => true,
                'null'           => false,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['income', 'expense'],
                'null'       => false,
            ],
            'is_active' => [
                'type'    => 'BOOLEAN',
                'default' => true,
                'null'    => false,
            ],
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

        // Primary key compuesta
        $this->forge->addKey(['business_id', 'category_number'], true);

        // Unique key para evitar duplicar categorías por negocio
        $this->forge->addUniqueKey(['business_id', 'name'], 'uk_business_category_name');

        // Índice para búsqueda por tipo más rápida
        $this->forge->addKey(['business_id', 'type'], false, false, 'idx_business_type');

        // Foreign key
        $this->forge->addForeignKey('business_id', 'businesses', 'id', 'CASCADE', 'RESTRICT');

        $this->forge->createTable('categories');
    }

    public function down()
    {
        $this->forge->dropTable('categories');
    }
}
