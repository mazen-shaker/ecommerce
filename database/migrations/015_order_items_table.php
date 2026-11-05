<?php

return "
    CREATE TABLE order_items (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        order_id BIGINT UNSIGNED NOT NULL,
        product_id BIGINT UNSIGNED DEFAULT NULL,
        product_name VARCHAR(200) COLLATE utf8mb4_unicode_ci NOT NULL,
        unit_price DECIMAL(10,2) NOT NULL,
        quantity INT UNSIGNED NOT NULL,
        line_total DECIMAL(10,2) NOT NULL,

        PRIMARY KEY (id),
        KEY idx_order_items_order_id (order_id),
        KEY idx_order_items_product_id (product_id),

        CONSTRAINT fk_order_items_order
            FOREIGN KEY (order_id) REFERENCES orders(id)
            ON DELETE CASCADE ON UPDATE CASCADE,

        CONSTRAINT fk_order_items_product
            FOREIGN KEY (product_id) REFERENCES products(id)
            ON DELETE SET NULL ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";
