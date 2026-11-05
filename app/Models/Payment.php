<?php

namespace App\Models;

use core\database\traits\HasCrud;

class Payment extends Model
{
    use HasCrud;

    protected string $table = 'payments';
}
