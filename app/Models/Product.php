<?php

namespace App\Models;

use core\database\traits\HasCrud;
use core\database\traits\FileSystem;


class Product extends Model
{
    use HasCrud,FileSystem;

    protected string $table = 'products';
}
