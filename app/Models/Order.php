<?php

namespace App\Models;

use core\database\traits\HasCrud;

class Order extends Model
{
    use HasCrud;

    protected string $table = 'orders';
}
