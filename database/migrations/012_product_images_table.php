<?php

return "
    CREATE TABLE product_images (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        product_id BIGINT UNSIGNED NOT NULL,
        image_path VARCHAR(500) COLLATE utf8mb4_unicode_ci NOT NULL,
        is_primary TINYINT(1) NOT NULL DEFAULT '0',
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

        PRIMARY KEY (id),
        KEY idx_product_images_product_id (product_id),

        CONSTRAINT fk_product_images_product
            FOREIGN KEY (product_id) REFERENCES products(id)
            ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";
