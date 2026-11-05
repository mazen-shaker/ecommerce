<?php

namespace App\Http\Controllers\Admin;

use core\view\Main;
use App\Models\User;

class UserController extends Main
{
    public object $model;

    public function __construct()
    {
        $this->model = new User();
    }

    public function createLogin()
    {

        if (isset($_SESSION['user']['logedIn'])) {
            return header("Location:" . $GLOBALS['basePath'] . "/" . $GLOBALS['previousUrl']);
        };

        return $this->view('user/auth/login');
    }


    public function createRegister()
    {

        if (isset($_SESSION['user']['logedIn'])) {
            return header("Location:" . $GLOBALS['basePath'] . "/" . $GLOBALS['previousUrl']);
        };

        return $this->view('user/auth/register');
    }

    public function register($data)
    {

        $this->model->insert([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT)
        ]);

        $_SESSION['user'] = [
            'logedIn' => true,
            'name' => $data['name']
        ];

        return header("Location:" . $GLOBALS['basePath'] . "/");
    }


    public function logout()
    {

        $_SESSION = [];

        session_destroy();

        return header("Location:" . $GLOBALS['basePath'] . "/");
    }

    public function login($data)
    {

        $user = $this->model->where('email', '=', $data['email']) ?? null;

        if ($user[0] != null && password_verify($data['password'], $user[0]['password'])) {

            $_SESSION['user'] = [
                'logedIn' => true,
                'name' => $user[0]['name']
            ];

            return header("Location:" . $GLOBALS['basePath'] . "/");
        };

        $_SESSION['error']['lgoinError'] =
            "The email or password you entered is incorrect.";

        return header("Location:" . $GLOBALS['basePath'] . "/" . $GLOBALS['previousUrl']);
    }
}
