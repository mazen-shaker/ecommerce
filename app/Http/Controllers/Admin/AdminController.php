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



    public function index(){
$admins = [
    [
        'id'         => 1,
        'name'       => 'Super Admin',
        'email'      => 'admin@example.com',
        'password'   => password_hash('admin123', PASSWORD_BCRYPT),
        'phone'      => '20100000001',
        'created_at' => '2026-10-01 08:00:00',
        'updated_at' => '2026-10-01 08:00:00',
    ],
    [
        'id'         => 2,
        'name'       => 'Mohamed Ali',
        'email'      => 'mohamed.admin@example.com',
        'password'   => password_hash('admin123', PASSWORD_BCRYPT),
        'phone'      => '20100000002',
        'created_at' => '2026-10-05 10:30:00',
        'updated_at' => '2026-10-20 14:15:00',
    ],
    [
        'id'         => 3,
        'name'       => 'Hana Samir',
        'email'      => 'hana.admin@example.com',
        'password'   => password_hash('admin123', PASSWORD_BCRYPT),
        'phone'      => '20100000003',
        'created_at' => '2026-10-10 12:45:00',
        'updated_at' => '2026-10-10 12:45:00',
    ],
    [
        'id'         => 4,
        'name'       => 'Karim Hassan',
        'email'      => 'karim.admin@example.com',
        'password'   => password_hash('admin123', PASSWORD_BCRYPT),
        'phone'      => '20100000004',
        'created_at' => '2026-10-15 09:20:00',
        'updated_at' => '2026-11-01 16:40:00',
    ],
];


    return $this->view('admin/index-admins',compact('admins'));

    }


    public function store($data) {
        
    $this->model->insert([
    'name' => $data['name'],
    'email' => $data['email'],
    'phone' => $data['phone'],
    'password' => password_hash($data['password'], PASSWORD_DEFAULT)
    ]);    
    return header("Location:".$GLOBALS['basePath']."/".$GLOBALS['previousUrl']);
    }


    public function logout(){

    $_SESSION = [];

    session_destroy();
        
    return header("Location:".$GLOBALS['basePath']."/");
    
    }


    public function profile(){

    $admin = $this->model->find($_SESSION['admin']['id']); 

    return $this->view('admin/auth/profile', $admin);

    }


public function profileUpdate($data){

    $admin = $this->model->find($_SESSION['admin']['id']);

    if (!isset($data['password']) && isset($data['oldpassword']) || isset($data['password']) && !isset($data['oldpassword'])) {

        $_SESSION['error']['prfilePassword'] =
        "Both password and oldpassword fields are required.";

        return header("Location:".$GLOBALS['basePath']."/".$GLOBALS['previousUrl']);

    }elseif (!isset($data['password']) && !isset($data['oldpassword'])) {

        $this->model->update($_SESSION['admin']['id'],[
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone']
        ]);

    }else{
        if(password_verify($data['oldpassword'], $admin['password']))

        $this->model->update($_SESSION['admin']['id'],[
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT)
        ]);

    }
    
    $updatedAdmin = $this->model->find($_SESSION['admin']['id']);
    
    $_SESSION['admin']['name'] = $updatedAdmin['name'];
    
    return header("Location:".$GLOBALS['basePath']."/".$GLOBALS['previousUrl']);

}

    public function login($data) {

    $admin = $this->model->where('name', '=', $data['name']) ?? null; 
       
    // return var_dump($data,$admin, $admin != null && password_verify($data['password'], $admin[0]['password'])); die();
    if($admin[0] != null && password_verify($data['password'], $admin[0]['password'])){
    $_SESSION['admin'] = [
    'logedIn' => true,
    'name' => $admin[0]['name'],
    'id' => $admin[0]['id'],
    ];

    return header("Location:".$GLOBALS['basePath']."/admin");
    };

    $_SESSION['error']['lgoinError'] =
    "The name or password you entered is incorrect.";

    return header("Location:".$GLOBALS['basePath']."/".$GLOBALS['previousUrl']);
    }

}




