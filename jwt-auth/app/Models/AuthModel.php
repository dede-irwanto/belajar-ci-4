<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $table                = 'users';
    protected $allowedFields        = ['first_name', 'last_name', 'email', 'password'];

    public function register($data)
    {
        $query = $this->insert($data);
        return $query ? \true : \false;
    }

    public function cekLogin($email)
    {
        $query = $this->where(['email' => $email])->countAll();

        if ($query > 0) {
            $hasil = $this->where(['email' => $email])->limit(1)->get()->getRowArray();
        } else {
            $hasil = [];
        }

        return $hasil;
    }
}
