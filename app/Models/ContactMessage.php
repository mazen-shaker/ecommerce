<?php

namespace App\Models;

use core\database\traits\HasCrud;

class ContactMessage extends Model
{
    use HasCrud;

    protected string $table = 'contact_messages';
}
