<?php

return "
    CREATE TABLE payments (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        order_id BIGINT UNSIGNED NOT NULL,
        method ENUM('cash_on_delivery', 'card', 'wallet', 'bank_transfer', 'other') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cash_on_delivery',
        amount DECIMAL(10,2) NOT NULL,
        status ENUM('pending', 'paid', 'failed', 'refunded') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
        transaction_reference VARCHAR(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        paid_at DATETIME DEFAULT NULL,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

        PRIMARY KEY (id),
        KEY idx_payments_order_id (order_id),

        CONSTRAINT fk_payments_order
            FOREIGN KEY (order_id) REFERENCES orders(id)
            ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";
