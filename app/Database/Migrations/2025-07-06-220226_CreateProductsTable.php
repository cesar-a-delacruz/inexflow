<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductsTable extends Migration
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
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'sku' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'comment'    => 'Código del producto'
            ],
            'cost_price' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0.00,
                'null'       => false,
                'comment'    => 'Precio de costo'
            ],
            'selling_price' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => false,
                'comment'    => 'Precio de venta'
            ],
            'is_service' => [
                'type'    => 'BOOLEAN',
                'default' => false,
                'null'    => false,
                'comment' => 'TRUE si es servicio'
            ],
            'track_inventory' => [
                'type'    => 'BOOLEAN',
                'default' => true,
                'null'    => false,
                'comment' => 'Si controla stock'
            ],
            'current_stock' => [
                'type'    => 'INT',
                'default' => 0,
                'null'    => false,
            ],
            'min_stock_level' => [
                'type'    => 'INT',
                'default' => 0,
                'null'    => false,
                'comment' => 'Para alertas'
            ],
            'unit_of_measure' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'unit',
                'null'       => false,
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
        $this->forge->addUniqueKey(['business_id', 'sku'], 'uk_business_sku');

        $this->forge->addForeignKey('business_id', 'businesses', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey(['business_id', 'category_number'], 'categories', ['business_id', 'category_number'], 'CASCADE', 'RESTRICT', 'fk_product_category');
        $this->forge->createTable('products');
    }

    public function down()
    {
        $this->forge->dropTable('products');
    }
}
