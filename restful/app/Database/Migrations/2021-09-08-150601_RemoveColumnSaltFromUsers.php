<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveColumnSaltFromUsers extends Migration
{
	public function up()
	{
		$this->forge->dropColumn('users', 'salt');
	}

	public function down()
	{
	}
}
