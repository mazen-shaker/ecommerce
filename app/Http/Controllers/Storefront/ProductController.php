<?php

namespace App\Http\Controllers\Storefront;

use core\view\Main;
use App\Models\Product;

class ProductController extends Main
{
    public object $model;

    public function __construct()
    {
        $this->model = new Product();
    }
}
