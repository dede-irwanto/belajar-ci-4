<?php

namespace App\Controllers;

use CodeIgniter\CodeIgniter;
use CodeIgniter\HTTP\Response;
use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;

class Users extends ResourceController
{
        protected $modelName = 'App\Models\UsersModel';
        protected $format = 'json';
        private $validation;
        private $rule_username;

        public function __construct()
        {
                $this->validation = \Config\Services::validation();
        }

        public function privateKey()
        {
                $privateKey = <<<EOD
                -----BEGIN RSA PRIVATE KEY-----
                MIICXAIBAAKBgQC8kGa1pSjbSYZVebtTRBLxBz5H4i2p/llLCrEeQhta5kaQu/Rn
                vuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t0tyazyZ8JXw+KgXTxldMPEL9
                5+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4ehde/zUxo6UvS7UrBQIDAQAB
                AoGAb/MXV46XxCFRxNuB8LyAtmLDgi/xRnTAlMHjSACddwkyKem8//8eZtw9fzxz
                bWZ/1/doQOuHBGYZU8aDzzj59FZ78dyzNFoF91hbvZKkg+6wGyd/LrGVEB+Xre0J
                Nil0GReM2AHDNZUYRv+HYJPIOrB0CRczLQsgFJ8K6aAD6F0CQQDzbpjYdx10qgK1
                cP59UHiHjPZYC0loEsk7s+hUmT3QHerAQJMZWC11Qrn2N+ybwwNblDKv+s5qgMQ5
                5tNoQ9IfAkEAxkyffU6ythpg/H0Ixe1I2rd0GbF05biIzO/i77Det3n4YsJVlDck
                ZkcvY3SK2iRIL4c9yY6hlIhs+K9wXTtGWwJBAO9Dskl48mO7woPR9uD22jDpNSwe
                k90OMepTjzSvlhjbfuPN1IdhqvSJTDychRwn1kIJ7LQZgQ8fVz9OCFZ/6qMCQGOb
                qaGwHmUK6xzpUbbacnYrIM6nLSkXgOAwv7XXCojvY614ILTK3iXiLBOxPu5Eu13k
                eUz9sHyD6vkgZzjtxXECQAkp4Xerf5TGfQXGXhxIX52yH+N2LtujCdkQZjXAsGdm
                B2zNzvrlgRmgBrklMTrMYgm1NPcW+bRLGcwgW2PTvNM=
                -----END RSA PRIVATE KEY-----
                EOD;
                return $privateKey;
        }

        public function login()
        {
                $data = $this->request->getPost();
                if ($this->cekLogin($data['username'])) {
                }
        }


        public function index()
        {
                return $this->respond($this->model->findAll());
        }

        public function create()
        {
                $data = $this->request->getPost();

                $this->rule_username = 'required|min_length[5]|is_unique[users.username]';

                if (!$this->validasi()) {
                        return $this->fail($this->validation->getErrors());
                }

                $user = new \App\Entities\Users();
                $user->fill($data);
                $user->created_by = $data['username'];
                $user->created_at = \CodeIgniter\I18n\Time::now();

                if ($this->model->save($user)) {
                        return $this->respondCreated($user, 'User created');
                }
        }

        public function update($id = null)
        {
                if (!$this->model->findByID($id)) {
                        return $this->fail('User tidak ditemukan!');
                }

                $data = $this->request->getRawInput();
                $data['id'] = $id;

                $this->rule_username = 'required|min_length[5]|is_unique[users.username,id,' . $id . ']';

                if (!$this->validasi()) {
                        return $this->fail($this->validation->getErrors());
                }

                $user = new \App\Entities\Users();
                $user->fill($data);
                $user->updated_by = $data['username'];
                $user->updated_at = \CodeIgniter\I18n\Time::now();

                if ($this->model->save($user)) {
                        return $this->respondUpdated($user, 'User updated');
                }
        }

        public function delete($id = null)
        {
                if (!$this->model->findByID($id)) {
                        return $this->fail('User tidak ditemukan!');
                }

                if ($this->model->delete($id)) {
                        return $this->respondDeleted([$id, 'User deleted']);
                }
        }

        public function show($id = null)
        {
                $data = $this->model->find($id);
                if ($data) {
                        return $this->respond($data);
                }

                return $this->fail('User tidak ditemukan!');
        }

        public function cekLogin($username)
        {
                $countUser = $this->model->findByUsername($username);

                if ($countUser > 0) {
                        $result = $this->model->where('username', $username)->limit(1)->get()->getResultArray();
                } else {
                        $result = [];
                }
                return $result;
        }

        private function validasi()
        {
                return $this->validate([
                        'username'         => [
                                'label'         => 'Username',
                                'rules'         => $this->rule_username,
                                'errors'        => [
                                        'required'      => '{field} tidak boleh kosong!',
                                        'min_lenght'    => '{field} minimal 5 karakter!',
                                        'is_unique'     => '{field} sudah terdaftar!'
                                ],
                        ],
                        'password'         => [
                                'label'         => 'Password',
                                'rules'         => 'required',
                                'errors'        => [
                                        'required'      => '{field} tidak boleh kosong!'
                                ],
                        ],
                        'password'         => [
                                'label'         => 'Password',
                                'rules'         => 'required',
                                'errors'        => [
                                        'required'      => '{field} tidak boleh kosong!'
                                ],
                        ],
                        'firstname'         => [
                                'label'         => 'Nama Depan',
                                'rules'         => 'required|alpha',
                                'errors'        => [
                                        'required'      => '{field} tidak boleh kosong!',
                                        'alpha'          => '{field} tidak boleh berisi angka!'
                                ],
                        ],
                        'lastname'         => [
                                'label'         => 'Nama Belakang',
                                'rules'         => 'required|alpha',
                                'errors'        => [
                                        'required'      => '{field} tidak boleh kosong!',
                                        'alpha'      => '{field} tidak boleh berisi angka!',
                                ],
                        ],
                        'age'         => [
                                'label'         => 'Umur',
                                'rules'         => 'required|numeric',
                                'errors'        => [
                                        'required'      => '{field} tidak boleh kosong!',
                                        'numeric'      => '{field} harus berisi angka!',
                                ],
                        ]
                ]);
        }
}
