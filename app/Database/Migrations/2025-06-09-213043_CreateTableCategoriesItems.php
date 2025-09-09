<?php

namespace App\Database\Migrations;

use App\Database\EntityMigration;

class CreateTableCategoriesItems extends EntityMigration
{
    public function up()
    {
        $this->forge->addField([

            'category_id' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'null'           => false,
            ],
            'item_id' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'null'           => false,
            ],
        ]);

        parent::tenetFields();

        $this->forge->addKey(['category_id', 'item_id'], true);
        $this->forge->addForeignKey('category_id', 'items', 'id');
        $this->forge->addForeignKey('item_id', 'categories', 'id');

        $this->forge->createTable('categories_items');
    }

    public function down()
    {
        $this->forge->dropTable('categories_items');
    }
}
