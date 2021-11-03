<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameColumnFistnameToFirstname extends Migration
{
	public function up()
	{
		$fields = [
			'fistname'	=> [
				'name'		=> 'firstname',
				'type'		=> 'VARCHAR',
				'constraint'	=> 255,
			]
		];
		$this->forge->modifyColumn('users', $fields);
	}

	public function down()
	{
		$fields = [
			'firstname'	=> [
				'name'		=> 'fistname',
				'type'		=> 'VARCHAR',
				'constraint'	=> 255,
			]
		];
		$this->forge->modifyColumn('users', $fields);
	}
}
