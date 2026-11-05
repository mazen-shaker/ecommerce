<?php

namespace App\Models;

use core\database\traits\HasCrud;

class OrderItem extends Model
{
    use HasCrud;

    protected string $table = 'order_items';
}
