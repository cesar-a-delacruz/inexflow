<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBusinessIdToRecords extends Migration
{
    public function up()
    {
        $this->forge->addColumn('records', [
            'business_id' => [
                'type' => 'BINARY',
                'constraint' => 16,
                'null' => false,
                'after' => 'id'
            ],
        ]);
        $this->db->query('ALTER TABLE `records` ADD INDEX `idx_records_business_id` (`business_id`)');
        $this->db->query('ALTER TABLE `records` ADD INDEX `idx_records_business_date` (`business_id`, `created_at`)');
        $this->forge->addForeignKey('business_id', 'businesses', 'id', 'CASCADE', 'RESTRICT', 'records_business_id_foreign');
    }

    public function down()
    {
        $this->forge->dropForeignKey('records', 'records_business_id_foreign');
        $this->db->query('ALTER TABLE `records` DROP INDEX `idx_records_business_id`');
        $this->db->query('ALTER TABLE `records` DROP INDEX `idx_records_business_date`');
        $this->forge->dropColumn('records', 'business_id');
    }
}
