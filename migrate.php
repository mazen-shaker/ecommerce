<?php

require_once './config/dataBase.php';

try {

    $db = new PDO(
        "mysql:host=$host",
        $username,
        $password
    );

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $db->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    $db->exec("USE $dbname");

    $files = glob('./database/migrations/*.php');
    sort($files);

    foreach ($files as $file) {

        $statements = require $file;

        if (!is_array($statements)) {
            $statements = [$statements];
        }

        $executed = false;

        foreach ($statements as $sql) {

            $affected = $db->exec($sql);

            if ($affected !== false) {
                $executed = true;
            }
        }

        if ($executed) {
            echo basename($file) . " executed successfully\n";
        }
    }

} catch (PDOException $e) {

    echo "Migration Error: " . $e->getMessage();

}
