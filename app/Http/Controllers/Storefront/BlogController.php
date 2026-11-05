<?php

namespace App\Http\Controllers\Storefront;

use core\view\Main;
use App\Models\BlogPost;

class BlogController extends Main
{
    public object $model;

    public function __construct()
    {
        $this->model = new BlogPost();
    }
}
