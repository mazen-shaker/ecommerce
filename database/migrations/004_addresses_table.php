<?php

return "
    CREATE TABLE addresses (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        user_id BIGINT UNSIGNED NOT NULL,
        city VARCHAR(100) COLLATE utf8mb4_unicode_ci NOT NULL,
        street VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        postal_code VARCHAR(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        is_default TINYINT(1) NOT NULL DEFAULT '0',
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

        PRIMARY KEY (id),
        KEY idx_addresses_user_id (user_id),

        CONSTRAINT fk_addresses_user
            FOREIGN KEY (user_id) REFERENCES users(id)
            ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";
