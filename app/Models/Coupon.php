<?php

namespace App\Models;

use core\database\traits\HasCrud;

class Coupon extends Model
{
    use HasCrud;

    protected string $table = 'coupons';
}
