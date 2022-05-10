<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGradesTable extends Migration
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
            'grade' => [
                'type' => 'INT',
                'constraint' => 2,
            ],
            'created_at datetime default current_timestamp',
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('grades');
    }

    public function down()
    {
        $this->forge->dropTable('grades');
    }
}
