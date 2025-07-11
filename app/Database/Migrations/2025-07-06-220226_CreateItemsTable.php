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
            'category_number' => [
                'type'           => 'SMALLINT',
                'constraint'     => 5,
                'unsigned'       => true,
                'null'           => true,
                'comment'        => 'Referencia a categoría de producto'
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
                'comment'    => 'Precio de costo'
            ],
            'selling_price' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
                'comment'    => 'Precio de venta'
            ],
            'current_stock' => [
                'type'    => 'INT',
                'default' => 0,
                'null'    => true,
            ],
            'min_stock' => [
                'type'    => 'INT',
                'default' => 0,
                'null'    => true,
                'comment' => 'Para alertas'
            ],
            'measure_unit' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'comment'    => 'unidad, kg, lb, etc.'
            ],
            'is_active' => [
                'type'    => 'BOOLEAN',
                'default' => true,
                'null'    => false,
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
        $this->forge->addKey(['business_id', 'name'], false, false, 'idx_business_product_name');
        $this->forge->addKey(['business_id', 'is_active'], false, false, 'idx_business_product_active');
        $this->forge->addKey(['business_id', 'current_stock'], false, false, 'idx_business_stock');

        $this->forge->addForeignKey('business_id', 'businesses', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey(['business_id', 'category_number'], 'categories', ['business_id', 'category_number'], 'CASCADE', 'RESTRICT', 'fk_product_category');
        $this->forge->createTable('items');
    }

    public function down()
    {
        $this->forge->dropTable('items');
    }
}
