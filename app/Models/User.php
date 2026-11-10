<?php

namespace App\Models;

use core\database\traits\HasCrud;

class User extends Model
{
    use HasCrud;

    protected string $table = 'users';
}
