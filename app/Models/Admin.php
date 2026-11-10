<?php

namespace App\Models;

use core\database\traits\HasCrud;

class Admin extends Model
{
    use HasCrud;

    protected string $table = 'admins';
}
