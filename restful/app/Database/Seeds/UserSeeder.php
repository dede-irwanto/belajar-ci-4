<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

use CodeIgniter\I18n\Time;

class UserSeeder extends Seeder
{
	public function run()
	{
		$noUser = 1;
		$noCreatedBy = 1;
		for ($i = 0; $i < 5; $i++) {

			switch ($i) {
				case 0:
					$firstname = 'Dede';
					$lastname = 'Irwanto';
					break;
				case 1:
					$firstname = 'Eka Wuryandari';
					$lastname = 'Potabuga';
					break;
				case 2:
					$firstname = 'Adeeva Dhiyaulhaq';
					$lastname = 'Jennaira';
					break;
				case 3:
					$firstname = 'Nazeefa Qotrunnada';
					$lastname = 'Salsabila';
					break;
				case 4:
					$firstname = 'Razeeta Jihan';
					$lastname = 'Syauqiah';
					break;
			}

			$data = [
				'username'	=> 'dee' . $noUser++,
				'firstname'	=> $firstname,
				'lastname'	=> $lastname,
				'address'	=> 'Jl. Gatot Subroto',
				'age'		=> 29,
				'password'	=> 'password.',
				'salt'		=> 'password.',
				'avatar'	=> null,
				'role'		=> 0,
				'created_by'	=> 'dee' . $noCreatedBy++,
				'created_at'	=> Time::now(),
				'updated_at'	=> null,
				'updated_by'	=> null
			];

			$this->db->table('users')->insert($data);
		}
	}
}
