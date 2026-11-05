<?php

namespace App\Http\Controllers\Customer;

use core\view\Main;
use App\Models\User;

class AuthController extends Main
{
    public object $model;

    public function __construct()
    {
        $this->model = new User();
    }
}
