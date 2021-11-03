<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $fields = [
            'id'            => [
                'type'              => 'INT',
                'constraint'        => 11,
                'auto_increment'    => true
            ],
            'first_name'    => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
            ],
            'last_name'    => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
            ],
            'email'    => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
            ],
            'password'    => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
            ],
        ];
        $this->forge->addField($fields);
        $this->forge->addKey('id');
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
