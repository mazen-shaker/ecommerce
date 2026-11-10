<?php

namespace App\Models;

use core\database\traits\HasCrud;

class CartItem extends Model
{
    use HasCrud;

    protected string $table = 'cart_items';
}
