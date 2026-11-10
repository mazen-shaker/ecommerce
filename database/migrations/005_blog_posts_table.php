<?php

return "
    CREATE TABLE blog_posts (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        author_id BIGINT UNSIGNED DEFAULT NULL,
        title VARCHAR(220) COLLATE utf8mb4_unicode_ci NOT NULL,
        slug VARCHAR(240) COLLATE utf8mb4_unicode_ci NOT NULL,
        excerpt TEXT COLLATE utf8mb4_unicode_ci,
        content LONGTEXT COLLATE utf8mb4_unicode_ci NOT NULL,
        image_path VARCHAR(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        status ENUM('draft', 'published', 'archived') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
        published_at DATETIME DEFAULT NULL,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

        PRIMARY KEY (id),
        UNIQUE KEY slug (slug),
        KEY fk_blog_posts_author (author_id),
        KEY idx_blog_posts_status_published (status, published_at),

        CONSTRAINT fk_blog_posts_author
            FOREIGN KEY (author_id) REFERENCES users(id)
            ON DELETE SET NULL ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";
