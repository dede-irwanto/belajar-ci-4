<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnUpdatedByToUsers extends Migration
{
	public function up()
	{
		$fields = [
			'updated_by' => [
				'type'		=> 'VARCHAR',
				'constraint'	=> 255,
				'null'		=> true
			]
		];
		$this->forge->addColumn('users', $fields);
	}

	public function down()
	{
		$this->forge->dropColumn('users', 'updated_by');
	}
}
