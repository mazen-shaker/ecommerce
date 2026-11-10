<?php

namespace App\Http\Controllers\Customer;

use core\view\Main;
use App\Models\Review;

class ReviewController extends Main
{
    public object $model;

    public function __construct()
    {
        $this->model = new Review();
    }
}
