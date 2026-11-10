<?php

return "
    CREATE TABLE orders (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        user_id BIGINT UNSIGNED NOT NULL,
        address_id BIGINT UNSIGNED DEFAULT NULL,
        coupon_id BIGINT UNSIGNED DEFAULT NULL,
        order_number VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL,
        subtotal DECIMAL(10,2) NOT NULL DEFAULT '0.00',
        discount_amount DECIMAL(10,2) NOT NULL DEFAULT '0.00',
        shipping_cost DECIMAL(10,2) NOT NULL DEFAULT '0.00',
        total DECIMAL(10,2) NOT NULL DEFAULT '0.00',
        status ENUM('pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled', 'refunded') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
        customer_name VARCHAR(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        customer_email VARCHAR(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        customer_phone VARCHAR(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        shipping_address TEXT COLLATE utf8mb4_unicode_ci,
        notes TEXT COLLATE utf8mb4_unicode_ci,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

        PRIMARY KEY (id),
        UNIQUE KEY order_number (order_number),
        KEY fk_orders_address (address_id),
        KEY fk_orders_coupon (coupon_id),
        KEY idx_orders_user_id (user_id),
        KEY idx_orders_status (status),
        KEY idx_orders_created_at (created_at),

        CONSTRAINT fk_orders_address
            FOREIGN KEY (address_id) REFERENCES addresses(id)
            ON DELETE SET NULL ON UPDATE CASCADE,

        CONSTRAINT fk_orders_coupon
            FOREIGN KEY (coupon_id) REFERENCES coupons(id)
            ON DELETE SET NULL ON UPDATE CASCADE,

        CONSTRAINT fk_orders_user
            FOREIGN KEY (user_id) REFERENCES users(id)
            ON DELETE RESTRICT ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";
