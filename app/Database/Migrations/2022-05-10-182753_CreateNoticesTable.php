<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNoticesTable extends Migration
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
            'teacher_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'lesson_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'student_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'message' => [
                'type' => 'TEXT',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['positive', 'negative', 'other']
            ],
            'created_at datetime default current_timestamp',
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('notices');
    }

    public function down()
    {
        $this->forge->dropTable('notices');
    }
}
