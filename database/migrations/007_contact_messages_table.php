<?php

return "
    CREATE TABLE contact_messages (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        user_id BIGINT UNSIGNED DEFAULT NULL,
        name VARCHAR(150) COLLATE utf8mb4_unicode_ci NOT NULL,
        email VARCHAR(190) COLLATE utf8mb4_unicode_ci NOT NULL,
        subject VARCHAR(220) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        message TEXT COLLATE utf8mb4_unicode_ci NOT NULL,
        status ENUM('new', 'read', 'replied', 'closed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

        PRIMARY KEY (id),
        KEY fk_contact_messages_user (user_id),
        KEY idx_contact_messages_status (status),
        KEY idx_contact_messages_created_at (created_at),

        CONSTRAINT fk_contact_messages_user
            FOREIGN KEY (user_id) REFERENCES users(id)
            ON DELETE SET NULL ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";
