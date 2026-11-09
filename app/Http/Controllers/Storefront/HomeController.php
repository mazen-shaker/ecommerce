<?php

namespace App\Http\Controllers\Storefront;

use App\testDataBase\getData;
use core\view\Main;

class HomeController extends Main
{

    public function index()
    {
        $products = new getData();

        $products = $products->get();
        return $this->view('user/index', compact('products'));
    }
}
