<?php

return "
    CREATE TABLE assets (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        product_id BIGINT UNSIGNED NOT NULL,
        file_path VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

        PRIMARY KEY (id),
        KEY product_id (product_id),

        CONSTRAINT fk_assets_product
            FOREIGN KEY (product_id)
            REFERENCES products(id)
            ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";
