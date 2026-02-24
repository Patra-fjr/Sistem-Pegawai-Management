<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PositionSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['position_name' => 'Manager'],
            ['position_name' => 'Staff'],
            ['position_name' => 'Supervisor'],
            ['position_name' => 'Direktur'],
        ];

        $this->db->table('positions')->insertBatch($data);
    }
}