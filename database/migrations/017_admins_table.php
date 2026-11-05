<?php

return "
    CREATE TABLE admins (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        name VARCHAR(150) COLLATE utf8mb4_unicode_ci NOT NULL,
        email VARCHAR(190) COLLATE utf8mb4_unicode_ci NOT NULL,
        password VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        phone VARCHAR(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

        PRIMARY KEY (id),
        UNIQUE KEY email (email)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";
