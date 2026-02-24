<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePositions extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'auto_increment' => true],
            'position_name' => ['type' => 'VARCHAR', 'constraint' => 100],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('positions');
    }

    public function down()
    {
        $this->forge->dropTable('positions');
    }
}