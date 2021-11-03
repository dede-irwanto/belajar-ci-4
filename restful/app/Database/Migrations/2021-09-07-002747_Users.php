<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

use function PHPSTORM_META\type;

class Users extends Migration
{
	public function up()
	{
		$fields = [
			'id'          => [
				'type'           => 'INT',
				'constraint'     => 5,
				'unsigned'       => true,
				'auto_increment' => true
			],
			'username'       => [
				'type'       	=> 'VARCHAR',
				'constraint'	=> '100',
				'unique'        => true,
				'null'		=> false
			],
			'fistname'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
				'null'		=> false
			],
			'lastname'	=> [
				'type'		=> 'VARCHAR',
				'constraint'	=> 100,
				'null'		=> false
			],
			'address'	=> [
				'type'		=> 'TEXT',
				'null'		=> false
			],
			'age'		=> [
				'type'		=> 'INT',
				'constraint'	=> 3,
				'null'		=> false
			],
			'password'	=> [
				'type'		=> 'VARCHAR',
				'constraint'	=> 255
			],
			'salt'		=> [
				'type'		=> 'VARCHAR',
				'constraint'	=> 255,
				'null'		=> false
			],
			'avatar'	=> [
				'type'		=> 'VARCHAR',
				'constraint'	=> 255,
				'null'		=> true
			],
			'role'		=> [
				'type'		=> 'INT',
				'constraint'	=> 1,
				'null'		=> false
			],
			'created_by'	=> [
				'type'		=> 'VARCHAR',
				'constraint'	=> 255,
				'null'		=> false
			],
			'created_at'	=> [
				'type'		=> 'DATETIME',
				'null'		=> false
			],
			'updated_at'	=> [
				'type'		=> 'DATETIME',
				'null'		=> true
			]
		];
		$this->forge->addField($fields);
		$this->forge->addKey('id', true);
		$this->forge->createTable('users');
	}

	public function down()
	{
		$this->forge->dropTable('users');
	}
}
