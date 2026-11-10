<?php

namespace App\Models;

use core\database\traits\HasCrud;

class Wishlist extends Model
{
    use HasCrud;

    protected string $table = 'wishlists';
}
