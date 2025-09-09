<?php

namespace App\Database\Migrations;

use App\Database\EntityMigration;

class CreateTransactionsTable extends EntityMigration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'       => 'SERIAL',
            ],
            'number' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
                'comment'    => 'Correlativo por negocio'
            ],
            'contact_id' => [
                'type'       => 'BIGINT',
                'unsigned' => true,
                'null'       => true,
                'comment'    => 'NULL para venta sin cliente'
            ],
            'payment_status' => [
                'type'       => 'ENUM',
                'constraint' => ['paid', 'pending', 'overdue', 'cancelled'],
                'default'    => 'paid',
                'null'       => false,
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'due_date' => [
                'type' => 'DATE',
                'null' => true,
                'comment' => 'Fecha de vencimiento para crédito'
            ],
        ]);

        parent::tenetFields();
        parent::auditableFields();

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['business_id', 'number']);
        $this->forge->addForeignKey('contact_id', 'contacts', 'id');

        $this->forge->createTable('transactions');
    }

    public function down()
    {
        $this->forge->dropTable('transactions');
    }
}
