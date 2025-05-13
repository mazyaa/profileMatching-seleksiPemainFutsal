<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;
class LoginController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new UsersModel();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Login',
            'page' => 'auth/login',
        ];

        return view('auth/login', $data);
    }

    public function login()
    {
        $json = $this->request->getJSON(true);

        $username = $json['username'];
        $password = $json['password'];

        $rules = [
            'username' => 'required',
            'password'     => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJson([
                'status' => 422,
                'message' => 'Semua field harus diisi'
            ])->setStatusCode(422);
        }


        $user = $this->model->where('username', $username)->first();

        if (!$user) {
            return $this->response->setJson([
                'status' => 401,
                'message' => 'Username tidak terdaftar'
            ])->setStatusCode(401);
        }

        $passwordVerify = password_verify($password, $user['password']);

        if (!$passwordVerify) {
            return $this->response->setJson([
                'status' => 400,
                'message' => 'Password salah'
            ])->setStatusCode(400);
        }

        if ($user && $passwordVerify) {
            session()->set([
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role'],
                'isLoggedIn' => true,
            ]);
            return $this->response->setJson([
                'status' => 200,
                'message' => 'Login berhasil',
                'role' => $user['role'],
            ])->setStatusCode(200);
        }
    }

    public function logout()
    {
        if (session()->get('isLoggedIn')) {
            session()->destroy();
            return $this->response->setJson([
                'status' => 200,
                'message' => 'Logout berhasil'
            ])->setStatusCode(200);
        } else if ($this->request->getMethod() !== 'POST') {
            return $this->response->setJson([
                'status' => 405,
                'message' => 'Method not allowed'
            ])->setStatusCode(405);
        } else {
            return $this->response->setJson([
                'status' => 401,
                'message' => 'Anda belum login'
            ])->setStatusCode(401);
        }
    }
}
