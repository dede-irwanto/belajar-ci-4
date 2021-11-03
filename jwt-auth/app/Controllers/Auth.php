<?php

namespace App\Controllers;

use Firebase\JWT\JWT;
use App\Models\AuthModel;
use CodeIgniter\RESTful\ResourceController;

class Auth extends ResourceController
{
        public function __construct()
        {
                $this->auth = new AuthModel();
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

        public function register()
        {
                $data = $this->request->getPost();

                $passwordHash = password_hash($data['password'], PASSWORD_BCRYPT);

                json_decode(file_get_contents("php://input"));

                $dataRegister = [
                        'first_name'    => $data['first_name'],
                        'last_name'     => $data['last_name'],
                        'email'         => $data['email'],
                        'password'      => $passwordHash
                ];

                $register = $this->auth->register($dataRegister);

                if ($register) {
                        $output = [
                                'status'        => 200,
                                'message'       => 'Berhasil register'
                        ];
                        return $this->respond($output, 200);
                } else {
                        $output = [
                                'status'        => 400,
                                'message'       => 'Gagal register'
                        ];
                        return $this->respond($output, 400);
                }
        }       

        public function login()
        {
                $data = $this->request->getPost();

                $cekLogin = $this->auth->cekLogin($data['email']);

                if (password_verify($data['password'], $cekLogin['password'])) {
                        $secretKey = $this->privateKey();
                        $issuerClaim = "THE CLAIM";
                        $audienceClaim = "THE AUDIENCE";
                        $issuedatClaim = time();
                        $notBeforeClaim = $issuedatClaim + 10;
                        $expireClaim = $issuedatClaim + 3600;
                        $token = [
                                'iss'   => $issuerClaim,
                                'aud'   => $audienceClaim,
                                'iat'   => $issuedatClaim,
                                'nbf'   => $notBeforeClaim,
                                'exp'   => $expireClaim,
                                'data'  => [
                                        'id'            => $cekLogin['id'],
                                        'firstName'     => $cekLogin['first_name'],
                                        'lastName'      => $cekLogin['last_name'],
                                        'email'         => $cekLogin['email']
                                ]
                        ];

                        $token = JWT::encode($token, $secretKey);

                        $output = [
                                'status'        => 200,
                                'message'       => 'Berhasil login',
                                'token'         => $token,
                                'email'         => $data['email'],
                                'expireAt'      => $expireClaim
                        ];

                        return $this->respond($output, 200);
                } else {
                        $output = [
                                'status'        => 401,
                                'message'       => 'Login failed',
                                'password'      => $data['password']
                        ];

                        return $this->respond($output, 401);
                }
        }

}
