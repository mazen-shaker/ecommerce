<?php

namespace App\Http\Controllers\Admin;

use core\view\Main;
use App\Models\Admin;

class AdminController extends Main
{
    public object $model;

    public function __construct()
    {
        $this->model = new Admin();
    }

    public function store($data)
    {
        $this->model->insert([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT)
        ]);

        return header("Location:" . $GLOBALS['basePath'] . "/" . $GLOBALS['previousUrl']);
    }

    public function logout()
    {
        $_SESSION = [];

        session_destroy();

        return header("Location:" . $GLOBALS['basePath'] . "/");
    }

    public function profile()
    {
        $admin = $this->model->find($_SESSION['admin']['id']);

        return $this->view('admin/auth/profile', $admin);
    }

    public function profileUpdate($data)
    {
        $admin = $this->model->find($_SESSION['admin']['id']);

        if (!$admin) {
            $_SESSION['error']['profileError'] = "Admin not found.";

            return header("Location:" . $GLOBALS['basePath'] . "/");
        }

        $hasPassword = !empty($data['password']);
        $hasOldPassword = !empty($data['oldpassword']);

        if ($hasPassword !== $hasOldPassword) {

            $_SESSION['error']['prfilePassword'] =
                "Both password and oldpassword fields are required.";

            return header("Location:" . $GLOBALS['basePath'] . "/" . $GLOBALS['previousUrl']);
        }

        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone']
        ];

        if ($hasPassword && $hasOldPassword) {

            if (!password_verify($data['oldpassword'], $admin['password'])) {

                $_SESSION['error']['prfilePassword'] =
                    "Old password is incorrect.";

                return header("Location:" . $GLOBALS['basePath'] . "/" . $GLOBALS['previousUrl']);
            }

            $updateData['password'] = password_hash(
                $data['password'],
                PASSWORD_DEFAULT
            );
        }

        $this->model->update($_SESSION['admin']['id'], $updateData);

        $updatedAdmin = $this->model->find($_SESSION['admin']['id']);

        $_SESSION['admin']['name'] = $updatedAdmin['name'];

        return header("Location:" . $GLOBALS['basePath'] . "/" . $GLOBALS['previousUrl']);
    }

    public function login($data)
    {
        $admin = $this->model->where(
            'name',
            '=',
            trim($data['name'])
        );

        if (!empty($admin) && password_verify($data['password'], $admin[0]['password'])) {

            session_regenerate_id(true);

            $_SESSION['admin'] = [
                'loggedIn' => true,
                'name' => $admin[0]['name'],
                'id' => $admin[0]['id'],
            ];

            return header("Location:" . $GLOBALS['basePath'] . "/admin");
        }

        $_SESSION['error']['loginError'] =
            "The name or password you entered is incorrect.";

        return header("Location:" . $GLOBALS['basePath'] . "/" . $GLOBALS['previousUrl']);
    }
}
