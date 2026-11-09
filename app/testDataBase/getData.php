<?php

namespace App\testDataBase;

class getData
{

    public function get()
    {
        include_once dirname(__FILE__) . '/productBase.php';
        return $products;
    }
}
