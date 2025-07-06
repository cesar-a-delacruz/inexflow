<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInventoryMovementsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'null'           => false,
                'auto_increment' => true
            ],
            'business_id' => [
                'type'       => 'BINARY',
                'constraint' => 16,
                'null'       => false,
            ],
            'product_id' => [
                'type'       => 'BINARY',
                'constraint' => 16,
                'null'       => false,
            ],
            'movement_type' => [
                'type'       => 'ENUM',
                'constraint' => ['in', 'out', 'adjustment'],
                'null'       => false,
            ],
            'quantity' => [
                'type' => 'INT',
                'null' => false,
            ],
            'unit_cost' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
                'comment'    => 'Costo unitario'
            ],
            'reference_type' => [
                'type'       => 'ENUM',
                'constraint' => ['sale', 'purchase', 'adjustment'],
                'null'       => true,
            ],
            'reference_id' => [
                'type' => 'INT',
                'null' => true,
                'comment' => 'ID de la factura, compra, etc.'
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_by' => [
                'type'       => 'BINARY',
                'constraint' => 16,
                'null'       => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey(['business_id', 'product_id'], false, false, 'idx_business_product');
        $this->forge->addKey(['business_id', 'movement_type'], false, false, 'idx_business_movement_type');
        $this->forge->addKey(['business_id', 'created_at'], false, false, 'idx_business_created_at');

        $this->forge->addForeignKey('business_id', 'businesses', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('created_by', 'users', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('inventory_movements');
    }

    public function down()
    {
        $this->forge->dropTable('inventory_movements');
    }
}
