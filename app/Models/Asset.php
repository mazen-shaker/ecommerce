<?php

namespace App\Models;

use core\database\traits\HasCrud;
use core\database\traits\FileSystem;

class Asset extends Model
{
    use HasCrud,FileSystem;


    protected string $table = 'assets';
}
