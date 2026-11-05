<?php

namespace App\Models;

use core\database\traits\HasCrud;

class Cart extends Model
{
    use HasCrud;

    protected string $table = 'carts';
}
