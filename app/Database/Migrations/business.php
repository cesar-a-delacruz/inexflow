<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class business extends Migration
{
    public function up()
    {
         $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'business_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'owner_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'owner_email' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'owner_phone' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'tax_id' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'comment' => 'NIT/RUC',
            ],
            'address'=>[
                'type' => 'TEXT',   
            ],
            'logo_url'=>[
                'type' => 'VARCHAR',
                'constraint' => '500'
            ],
            'onboarding_completed'=>[
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'status'=>[
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive', 'suspended'],
                'default'    => 'active',
            ],
             'registered_by'=>[
                'type' => 'INT',
                'unsigned' => true,
                'null'     => true,
                'comment' => 'FK → app_user.id',
            ],
            'created_at'=>[
                'type'=>'TIMESTAMP',
            ],
            'update_at'=>[
                'type'=>'TIMESTAMP',
            ],
            'delete_at'=>[
                'type'=>'TIMESTAMP',
            ],
        ]);
        $this->forge->addKey('id', true);
        
        // Índice y FK a app_user.id
        $this->forge->addKey('registered_by');
        $this->forge->addForeignKey('registered_by', 'app_user', 'id', 'CASCADE', 'SET NULL');
        
        $this->forge->createTable('business');
    }

    public function down()
    {
        $this->forge->dropTable('business');
    }
}