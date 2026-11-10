<?php

namespace App\Models;

use core\database\traits\HasCrud;

class ProductImage extends Model
{
    use HasCrud;

    protected string $table = 'product_images';
}
