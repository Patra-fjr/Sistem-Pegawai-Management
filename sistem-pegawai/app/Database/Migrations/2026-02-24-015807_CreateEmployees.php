<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmployees extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'auto_increment' => true],
            'user_id'       => ['type' => 'INT'],
            'department_id' => ['type' => 'INT'],
            'position_id'   => ['type' => 'INT'],
            'nip'           => ['type' => 'VARCHAR', 'constraint' => 20],
            'gender'        => ['type' => 'ENUM', 'constraint' => ['Laki-laki', 'Perempuan']],
            'phone'         => ['type' => 'VARCHAR', 'constraint' => 20],
            'address'       => ['type' => 'TEXT'],
            'photo'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'salary'        => ['type' => 'DECIMAL', 'constraint' => '15,2'],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('department_id', 'departments', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('position_id', 'positions', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('employees');
    }

    public function down()
    {
        $this->forge->dropTable('employees');
    }
}