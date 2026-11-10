<?php

return "
    CREATE TABLE coupons (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        code VARCHAR(80) COLLATE utf8mb4_unicode_ci NOT NULL,
        discount_type ENUM('percentage', 'fixed') COLLATE utf8mb4_unicode_ci NOT NULL,
        discount_value DECIMAL(10,2) NOT NULL,
        starts_at DATETIME DEFAULT NULL,
        expires_at DATETIME DEFAULT NULL,
        usage_limit INT UNSIGNED DEFAULT NULL,
        is_active TINYINT(1) NOT NULL DEFAULT '1',
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

        PRIMARY KEY (id),
        UNIQUE KEY code (code)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";
