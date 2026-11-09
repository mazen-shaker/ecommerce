<?php

namespace App\Http\Controllers\Customer;

use core\view\Main;
use App\Models\Order;

class CheckoutController extends Main
{
    public object $model;

    public function __construct()
    {
        $this->model = new Order();
    }
    public function index()
    { 
        $cart = [
            ['name' => 'T-shirt', 'price' => 200],
            ['name' => 'Shoes', 'price' => 500]
        ];
        return $this->view('user/checkout', compact('cart'));
    }
}
