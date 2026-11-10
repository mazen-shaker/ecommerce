<?php

namespace App\Http\Controllers\Admin;

use core\view\Main;
use App\Models\BlogPost;

class BlogPostController extends Main
{
    public object $model;

    public function __construct()
    {
        $this->model = new BlogPost();
    }
}
