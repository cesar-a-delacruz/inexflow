<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRecipesTable extends Migration
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
            'product_id' => [
                'type'       => 'BINARY',
                'constraint' => 16,
                'null'       => false,
            ],
            'ingredient_id' => [
                'type'       => 'BINARY',
                'constraint' => 16,
                'null'       => false,
            ],
            'quantity' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => false,
            ],
            'measure_unit' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'default'    => 'unidad'
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
        $this->forge->addForeignKey('product_id', 'items', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('ingredient_id', 'items', 'id', 'CASCADE', 'RESTRICT');

        $this->forge->createTable('recipes');
    }

    public function down()
    {
        $this->forge->dropTable('recipes');
    }
}
