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


}
