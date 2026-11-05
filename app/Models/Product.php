<?php

namespace App\Models;

use core\database\traits\HasCrud;

class Product extends Model
{
    use HasCrud;

    protected string $table = 'products';
}
