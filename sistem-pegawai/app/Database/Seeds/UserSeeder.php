<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'     => 'Administrator',
                'email'    => 'admin@gmail.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role'     => 'admin',
            ],
            [
                'name'     => 'Budi Santoso',
                'email'    => 'budi@gmail.com',
                'password' => password_hash('budi123', PASSWORD_DEFAULT),
                'role'     => 'pegawai',
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}