<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDefaultDatetimeToColumnCreatedAt extends Migration
{
	public function up()
	{
		$fields = [
			'created_at'	=> [
				'name'		=> 'created_at',
				'type'		=> 'DATETIME',
				'current_timestamp'	=> true
			]
		];
		$this->forge->modifyColumn('users', $fields);
	}

	public function down()
	{
		$fields = [
			'created_at'	=> [
				'name'		=> 'created_at',
				'type'		=> 'DATETIME',
			]
		];
		$this->forge->modifyColumn('users', $fields);
	}
}
