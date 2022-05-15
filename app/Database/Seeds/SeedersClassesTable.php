<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SeedersClassesTable extends Seeder
{
    public function run()
    {
        $classes = [
            [
                'title' => '5A',
                'max_week_lessons' => 25,
            ],
            [
                'title' => '5B',
                'max_week_lessons' => 25,
            ],
            [
                'title' => '7A',
                'max_week_lessons' => 30,
            ],
            [
                'title' => '12A',
                'max_week_lessons' => 40,
            ]
        ];
        $this->db->table('classes')->insertBatch($classes);
    }
}
