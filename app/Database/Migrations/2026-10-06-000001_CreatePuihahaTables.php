<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePuihahaTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('username');
        $this->forge->createTable('user_accounts', true);

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'account_number' => ['type' => 'VARCHAR', 'constraint' => 30],
            'customer_name' => ['type' => 'VARCHAR', 'constraint' => 150],
            'address' => ['type' => 'VARCHAR', 'constraint' => 255],
            'phone' => ['type' => 'VARCHAR', 'constraint' => 30],
            'email' => ['type' => 'VARCHAR', 'constraint' => 150],
            'meter_number' => ['type' => 'VARCHAR', 'constraint' => 50],
            'connection_type' => ['type' => 'VARCHAR', 'constraint' => 20],
            'status' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'active'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('account_number');
        $this->forge->createTable('customer_accounts', true);
    }

    public function down()
    {
        $this->forge->dropTable('customer_accounts', true);
        $this->forge->dropTable('user_accounts', true);
    }
}