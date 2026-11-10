<?php

namespace App\Http\Controllers\Customer;

use App\Models\Cart;
use App\Models\Product;
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
        $carts = $_SESSION['cart'] ?? [];
        // echo "<pre>";
        // print_r($carts);        
        return $this->view('user/cart', compact('carts'));
    }

    public function add($data)
    {
        $getProduct = new Product();
        $id = $data['product_id'] ?? '';
        $products = $getProduct->where('id', '=', $id);

        foreach ($products ?? [] as $product) {
            if ($id == $product['id']) {
                $_SESSION['cart'][] = $product;
            }
        }

        header('Location: ' . $GLOBALS['basePath'] . '/cart');
        return '';
    }
    public function destroy($data)
    {
        $cartIndex = $data['index'];

        if ($cartIndex !== false && isset($_SESSION['cart'][$cartIndex])) {
            unset($_SESSION['cart'][$cartIndex]);
        }

        header('Location: ' . $GLOBALS['basePath'] . '/cart');
        return '';
    }
}
