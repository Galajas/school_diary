<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SeedersUsersTable extends Seeder
{
    public function run()
    {
        $this->db->table('users')->truncate();

        $users = [
            [
                'email' => 'arturas@mokykla.lt',
                'password' => md5('Arturasdir'),
                'firstname' => 'Artūras',
                'lastname' => 'Petrauskas',
                'type' => 'director'
            ]
        ];
        $this->db->table('users')->insertBatch($users);
    }
}
