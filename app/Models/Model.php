<?php

namespace App\Models;

use PDO;
use App\Core\Database\Connection;

abstract class Model
{
    protected PDO $db;
    protected string $table;

    public function __construct()
    {
        $this->db = Connection::connect();
    }
}
