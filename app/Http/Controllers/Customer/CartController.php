<?php

namespace App\Http\Controllers\Customer;

use App\Models\Cart;
use App\testDataBase\getData;
use core\view\Main;

class CartController extends Main
{
    public object $model;

    public function __construct()
    {
        $this->model = new Cart();
    }
    public function index()
    {
        $getProducts = new getData();
        $products = $getProducts->get();
        $id = $_GET['id'] ?? null;
        foreach ($products ?? [] as $product) {
            if ($id == $product['id']) {
                $_SESSION['cart'][] = $product;
            }
        }
        $carts = $_SESSION['cart'];
        return $this->view('user/cart', compact('carts'));
    }
}
