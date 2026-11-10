<?php

namespace App\Models;

use core\database\traits\HasCrud;

class BlogPost extends Model
{
    use HasCrud;

    protected string $table = 'blog_posts';
}
