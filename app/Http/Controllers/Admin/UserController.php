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


    public function index()
    {
       $users = $this->model->all();

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

        $userId = $this->model->insert([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT)
        ]);

        $_SESSION['user'] = [
            'logedIn' => true,
            'name' => $data['name'],
            'id' => $userId
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
                'name' => $user[0]['name'],
                'id' => $user[0]['id']
            ];

            return header("Location:" . $GLOBALS['basePath'] . "/");
        };

        $_SESSION['error']['lgoinError'] =
            "The email or password you entered is incorrect.";

        return header("Location:" . $GLOBALS['basePath'] . "/" . $GLOBALS['previousUrl']);
    }


    public function store($data)
    {

        if(isset($_SESSION['admin']['logedIn'])){
        $this->model->insert([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT)
        ]);
        }


        return header("Location:" . $GLOBALS['basePath'] . "/" . $GLOBALS['previousUrl']);

    }


    public function update($data)
    {


        if(isset($_SESSION['admin']['logedIn'])){

        if($data['password']){
        $this->model->update($data['id'],[
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT)
        ]);
        }else{
        $this->model->update($data['id'],[
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
        ]);
        } 
        }
        return header("Location:" . $GLOBALS['basePath'] . "/" . $GLOBALS['previousUrl']);
    }

    public function destroy($data)
    {
        if(isset($_SESSION['admin']['logedIn'])){
        $this->model->destroy($data['id']);
        }
        return header("Location:" . $GLOBALS['basePath'] . "/" . $GLOBALS['previousUrl']);
    }


}
