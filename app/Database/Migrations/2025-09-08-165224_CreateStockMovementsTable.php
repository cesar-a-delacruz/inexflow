<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStockMovementsTable extends Migration
{
    /**
     *  id            serial primary key,
     *  business_id   binary(16)      not null,
     *  product_id    bigint unsigned not null,
     *  ingredient_id bigint unsigned not null,
     * quantity      decimal(10, 2)  not null,
     * measure_unit  varchar(20) default 'unidad',
     * constraint foreign key (business_id) references businesses (id),
     * constraint foreign key (product_id) references items (id),
     * constraint foreign key (ingredient_id) references items (id)
     */
    public function up()
    {
        /**
         * # Una tabla común para todos los tipos de inventario.
         *# (Así no repites lógica de entradas/salidas en cada tabla).
         *create table stock_movements
         *(
         *  id             serial primary key,
         *  business_id    binary(16)                                          not null,
         * item_id        bigint unsigned                                     not null,
         *  movement_type  enum ('purchase','sale','consumption','adjustment') not null,
         *   quantity       int                                                 not null,
         * created_at     datetime                                            not null,
         *  constraint foreign key (item_id) references items (id),
         *   constraint foreign key (business_id) references businesses (id)
         *);
         */
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
            'item_id' => [
                'type'       => 'BINARY',
                'constraint' => 16,
                'null'       => false,
            ],
            'movement_type' => [
                "type" => 'ENUM',
                'constraint' => ['purchase', 'sale', 'consumption', 'adjustment'],
                'null'       => false,
            ],
            'quantity' => [
                'type'       => 'INT',
                'null'       => false,
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
        $this->forge->addForeignKey('item_id', 'items', 'id', 'CASCADE', 'RESTRICT');

        $this->forge->createTable('stock_movements');
    }

    public function down()
    {
        $this->forge->dropTable('stock_movements');
    }
}
