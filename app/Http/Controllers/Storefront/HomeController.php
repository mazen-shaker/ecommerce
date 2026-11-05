<?php

namespace App\Http\Controllers\Storefront;

use core\view\Main;

class HomeController extends Main
{

    public function index()
    {
        return $this->view('user/index');
    }

}
