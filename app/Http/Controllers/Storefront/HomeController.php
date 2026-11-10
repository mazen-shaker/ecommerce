<?php

namespace App\Http\Controllers\Storefront;

use App\testDataBase\getData;
use core\view\Main;
use App\Models\Asset;
use App\Models\Product;

class HomeController extends Main
{

    public function index()
    {
        

        $products = (new Product)->all();
        foreach ($products as $index => $values) {
        $images = (new Asset)->where('product_id','=',$products[$index]['id']);
        $products[$index]['image'] = $images; 
        $products[$index]['thub'] = $images[0]; 
        }

        return $this->view('user/index', compact('products'));
    }
}
