<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
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
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '60',
                'unique' => true,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '32',
            ],
            'firstname' => [
                'type' => 'VARCHAR',
                'constraint' => '30',
            ],
            'lastname' => [
                'type' => 'VARCHAR',
                'constraint' => '30',
            ],
            'type' => [
                'type' => 'ENUM',
                'constraint' => ['director', 'teacher', 'student']
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
