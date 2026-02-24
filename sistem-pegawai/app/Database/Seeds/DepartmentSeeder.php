<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['department_name' => 'IT'],
            ['department_name' => 'HR'],
            ['department_name' => 'Finance'],
            ['department_name' => 'Marketing'],
        ];

        $this->db->table('departments')->insertBatch($data);
    }
}
