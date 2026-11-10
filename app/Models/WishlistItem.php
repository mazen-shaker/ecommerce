<?php

namespace App\Models;

use core\database\traits\HasCrud;

class WishlistItem extends Model
{
    use HasCrud;

    protected string $table = 'wishlist_items';
}
