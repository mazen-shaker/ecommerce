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



public function checkout()
{
$carts = $_SESSION['cart'] ?? [];

    $total = 0;

    foreach ($carts as $cart) {
        $total += $cart['price'] * ($cart['quantity'] ?? 1);
    }

    return $this->view('user/checkout', compact('carts', 'total'));
}


public function index()
{
    $carts = $_SESSION['cart'] ?? [];

    $total = 0;

    foreach ($carts as $cart) {
        $total += $cart['price'] * ($cart['quantity'] ?? 1);
    }

    return $this->view('user/cart', compact('carts', 'total'));
}
    public function add($data)
    {
        $getProduct = new Product();

        $id = $data['product_id'] ?? '';

        $products = $getProduct->where('id', '=', $id);

        foreach ($products ?? [] as $product) {

            if ($id == $product['id']) {

                if (isset($_SESSION['cart'][$id])) {

                    $_SESSION['cart'][$id]['quantity']++;

                } else {

                    $product['quantity'] = 1;

                    $_SESSION['cart'][$id] = $product;
                }
            }
        }

        header("Location:" . $GLOBALS['basePath'] . "/" . $GLOBALS['previousUrl']);
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

