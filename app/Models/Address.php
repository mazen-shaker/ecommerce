<?php

namespace App\Models;

use core\database\traits\HasCrud;

class Address extends Model
{
    use HasCrud;

    protected string $table = 'addresses';
}
