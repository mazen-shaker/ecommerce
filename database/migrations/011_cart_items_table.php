<?php

return "
    CREATE TABLE cart_items (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        cart_id BIGINT UNSIGNED NOT NULL,
        product_id BIGINT UNSIGNED NOT NULL,
        quantity INT UNSIGNED NOT NULL DEFAULT '1',
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

        PRIMARY KEY (id),
        UNIQUE KEY uq_cart_product (cart_id, product_id),
        KEY idx_cart_items_product_id (product_id),

        CONSTRAINT fk_cart_items_cart
            FOREIGN KEY (cart_id) REFERENCES carts(id)
            ON DELETE CASCADE ON UPDATE CASCADE,

        CONSTRAINT fk_cart_items_product
            FOREIGN KEY (product_id) REFERENCES products(id)
            ON DELETE RESTRICT ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";
