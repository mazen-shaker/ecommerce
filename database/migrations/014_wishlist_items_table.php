<?php

return "
    CREATE TABLE wishlist_items (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        wishlist_id BIGINT UNSIGNED NOT NULL,
        product_id BIGINT UNSIGNED NOT NULL,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

        PRIMARY KEY (id),
        UNIQUE KEY uq_wishlist_product (wishlist_id, product_id),
        KEY idx_wishlist_items_product_id (product_id),

        CONSTRAINT fk_wishlist_items_product
            FOREIGN KEY (product_id) REFERENCES products(id)
            ON DELETE CASCADE ON UPDATE CASCADE,

        CONSTRAINT fk_wishlist_items_wishlist
            FOREIGN KEY (wishlist_id) REFERENCES wishlists(id)
            ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";
