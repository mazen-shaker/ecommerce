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


    public function index(){

   $users = [
    [
        'id'         => 1,
        'name'       => 'ahmed',
        'email'      => 'ahmed@example.com',
        'password'   => password_hash('123456', PASSWORD_BCRYPT),
        'phone'      => '20101234567',
        'created_at' => '2026-11-01 09:15:20',
        'updated_at' => '2026-11-01 09:15:20',
    ],
    [
        'id'         => 2,
        'name'       => 'sara',
        'email'      => 'sara@example.com',
        'password'   => password_hash('123456', PASSWORD_BCRYPT),
        'phone'      => '20111234567',
        'created_at' => '2026-11-02 11:30:45',
        'updated_at' => '2026-11-02 11:30:45',
    ],
    [
        'id'         => 3,
        'name'       => 'omar',
        'email'      => 'omar@example.com',
        'password'   => password_hash('123456', PASSWORD_BCRYPT),
        'phone'      => '20121234567',
        'created_at' => '2026-11-03 14:05:10',
        'updated_at' => '2026-11-03 14:05:10',
    ],
    [
        'id'         => 4,
        'name'       => 'mazen',
        'email'      => 'mazen@mazen.mazen',
        'password'   => password_hash('123456', PASSWORD_BCRYPT),
        'phone'      => '20123456789',
        'created_at' => '2026-11-05 17:17:48',
        'updated_at' => '2026-11-05 17:17:48',
    ],
    [
        'id'         => 5,
        'name'       => 'nour',
        'email'      => 'nour@example.com',
        'password'   => password_hash('123456', PASSWORD_BCRYPT),
        'phone'      => '20151234567',
        'created_at' => '2026-11-05 18:42:33',
        'updated_at' => '2026-11-05 18:42:33',
    ],
    [
        'id'         => 6,
        'name'       => 'youssef',
        'email'      => 'youssef@example.com',
        'password'   => password_hash('123456', PASSWORD_BCRYPT),
        'phone'      => '20109876543',
        'created_at' => '2026-11-05 20:10:05',
        'updated_at' => '2026-11-05 20:10:05',
    ],
]; 




    return $this->view('admin/index-users',compact('users'));

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
