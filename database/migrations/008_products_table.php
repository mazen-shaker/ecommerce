<?php

return "
    CREATE TABLE products (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        category_id BIGINT UNSIGNED DEFAULT NULL,
        name VARCHAR(200) COLLATE utf8mb4_unicode_ci NOT NULL,
        description TEXT COLLATE utf8mb4_unicode_ci,
        price DECIMAL(10,2) NOT NULL,
        old_price DECIMAL(10,2) DEFAULT NULL,
        stock INT UNSIGNED NOT NULL DEFAULT '0',
        is_active TINYINT(1) NOT NULL DEFAULT '1',
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

        PRIMARY KEY (id),
        KEY idx_products_category_id (category_id),
        KEY idx_products_name (name),

        CONSTRAINT fk_products_category
            FOREIGN KEY (category_id) REFERENCES categories(id)
            ON DELETE SET NULL ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";
