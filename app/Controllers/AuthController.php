<?php

namespace App\Controllers;

session_start();

use App\Lib\Controller;
use App\Lib\Validation;
use App\Models\User;

class AuthController extends Controller
{
    private $model;

    const SESSION_KEY = 'login_customer';

    public function __construct()
    {
        $this->model = new User();
    }

    private function requestMutator(array $data)
    {
        $data['password'] = password_hash($data['password'], PASSWORD_ARGON2I);

        return $data;
    }

    public function index()
    {
        return $this->view('register', ['title' => 'Test1']);
    }

    public function register(array $data)
    {
        $request = $this->requestMutator($data);

        $validation = Validation::make($data, [
            'name' => ['required', 'min:2'],
            'password' => ['required', 'min:6', 'password_confirmation'],
            'email' => ['unique:users'],
        ]);

        if (!empty($validation['errors']) && count($validation['errors'])) {
            return $this->view('register', $validation);
        }

        $this->model->create($request);

        return $this->view('index', ['message' => 'Success created']);
    }

    public function login()
    {
        return $this->view('login');
    }

    public function auth(array $request)
    {
        $validation = Validation::make($request, [
            'email' => ['required'],
            'password' => ['required'],
        ]);

        if (!empty($validation['errors'])) {
            return $this->view('login', $validation);
        }

        ['email' => $email, 'password' => $password] = $request;

        $user = $this->model->find('email', $email);

        if (!password_verify($password, $user['password']) || !$email) {
            $v = Validation::pushError('password', 'This credential not correct');

            return $this->view('login', $validation);
        }

        $_SESSION[self::SESSION_KEY] = $user['id'];

        return true;
    }
}
