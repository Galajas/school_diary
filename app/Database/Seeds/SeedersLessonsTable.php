<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SeedersLessonsTable extends Seeder
{
    public function run()
    {
        $lessons = [
            [
                'title' => 'Biologija'
            ],
            [
                'title' => 'Matematika'
            ],
            [
                'title' => 'Lietuvių kalba'
            ],
            [
                'title' => 'Anglų kalba'
            ],
            [
                'title' => 'Istorija'
            ],
            [
                'title' => 'Geografija'
            ],
            [
                'title' => 'Fizika'
            ],
            [
                'title' => 'Chemija'
            ],
            [
                'title' => 'Dailė'
            ],
            [
                'title' => 'Muzika'
            ],
            [
                'title' => 'Kūno kultūra'
            ],
            [
                'title' => 'Informatika'
            ],
        ];

        $this->db->table('lessons')->insertBatch($lessons);
    }
}
