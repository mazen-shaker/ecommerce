<?php

namespace App\Http\Controllers\Storefront;

use App\Models\Product;
use App\testDataBase\getData;
use core\view\Main;

class ProductController extends Main
{
    public object $model;

    public function __construct()
    {
        $this->model = new Product();
    }
    public function index()
    {
        $products = new getData();

        $products = $products->get();
        return $this->view('user/index', compact('products'));
    }

    public function create()
    {
        return $this->view('user/product/index');
    }
    public function store()
    {
        return $this->view('user/product/index');
    }
    public function ProductDetails()
    {
        $getProducts = new getData();
        $products = $getProducts->get();
        $id = $_GET['id'] ?? null;
        $dataProduct = [] ?? '';
        foreach ($products ?? [] as $product) {
            if ($id == $product['id']) {
                $dataProduct = $product;
                break;
            }
        }

        return $this->view('user/product-details', compact('dataProduct'));
    }
}
