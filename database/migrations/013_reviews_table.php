<?php

return "
    CREATE TABLE reviews (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        user_id BIGINT UNSIGNED NOT NULL,
        product_id BIGINT UNSIGNED NOT NULL,
        rating TINYINT UNSIGNED NOT NULL,
        comment TEXT COLLATE utf8mb4_unicode_ci,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

        PRIMARY KEY (id),
        UNIQUE KEY uq_review_user_product (user_id, product_id),
        KEY idx_reviews_product_id (product_id),

        CONSTRAINT fk_reviews_product
            FOREIGN KEY (product_id) REFERENCES products(id)
            ON DELETE CASCADE ON UPDATE CASCADE,

        CONSTRAINT fk_reviews_user
            FOREIGN KEY (user_id) REFERENCES users(id)
            ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";
