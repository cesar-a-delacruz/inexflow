<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTotalToTransaction extends Migration
{
    public function up()
    {
        $this->forge->addColumn('transactions', [
            'total' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('transactions', 'total');
    }
}
