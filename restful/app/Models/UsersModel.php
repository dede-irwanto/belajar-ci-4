<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
	protected $table                = 'users';
	protected $primaryKey           = 'id';
	protected $allowedFields        = [
		'username', 'firstname', 'lastname', 'address', 'age', 'password', 'salt', 'avatar', 'role', 'created_by', 'created_at', 'updated_at', 'updated_by', 'id'
	];
	protected $returnType = 'App\Entities\Users';
	protected $useTimestamps = false;

	public function findByID($id)
	{
		return $this->find($id) ? true : false;
	}

	public function findByUsername($username)
	{
		return $this->where(['username' => $username])->countAll();
	}
}
