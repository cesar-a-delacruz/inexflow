<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateItemsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'       => 'BINARY',
                'constraint' => 16,
                'null'       => false,
            ],
            'business_id' => [
                'type'       => 'BINARY',
                'constraint' => 16,
                'null'       => false,
            ],
            'category_id' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'null'           => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'type' => [
                'type'    => 'ENUM',
                'constraint' => ['product', 'service'],
                'default'    => 'product',
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
            'stock' => [
                'type'    => 'INT',
                'default' => 0,
                'null'    => true,
            ],
            'min_stock' => [
                'type'    => 'INT',
                'default' => 0,
                'null'    => true,
            ],
            'measure_unit' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('business_id', 'businesses', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('category_id', 'categories','id', 'CASCADE', 'RESTRICT', 'fk_product_category');
        
        $this->forge->createTable('items');
    }

    public function down()
    {
        $this->forge->dropTable('items');
    }
}
