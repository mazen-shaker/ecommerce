<?php

return "
    CREATE TABLE carts (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        user_id BIGINT UNSIGNED DEFAULT NULL,
        session_id VARCHAR(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

        PRIMARY KEY (id),
        KEY idx_carts_user_id (user_id),
        KEY idx_carts_session_id (session_id),

        CONSTRAINT fk_carts_user
            FOREIGN KEY (user_id) REFERENCES users(id)
            ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";
