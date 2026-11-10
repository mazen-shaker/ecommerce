<?php

namespace App\Models;

use core\database\traits\HasCrud;

class Review extends Model
{
    use HasCrud;

    protected string $table = 'reviews';
}
