<?php

namespace App\Models;

use core\database\traits\HasCrud;

class Category extends Model
{
    use HasCrud;

    protected string $table = 'categories';
}
