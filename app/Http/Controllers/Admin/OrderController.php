<?php

namespace App\Http\Controllers\Admin;

use core\view\Main;
use App\Models\Order;

class OrderController extends Main
{
    public object $model;

    public function __construct()
    {
        $this->model = new Order();
    }


    public function index()
    {
       $orders = $this->model->all();

        return $this->view('admin/index-orders',compact('orders'));
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


}
