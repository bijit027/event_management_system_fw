<?php

namespace EventManagementSystem\Database\Migrations;

class BikeMigrator
{
    static $tableName = 'bikes';

    public static function migrate()
    {
        global $wpdb;

        $charsetCollate = $wpdb->get_charset_collate();

        $table = $wpdb->prefix . static::$tableName;

        if ($wpdb->get_var("SHOW TABLES LIKE '$table'") != $table) {
            $sql = "CREATE TABLE $table (
                `id` BIGINT(20) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
                `store_id` BIGINT(20),
                `image` VARCHAR(255),
                `brand` VARCHAR(200),
                `model` VARCHAR(200),
                `price` VARCHAR(200),
                `description` VARCHAR(255),
                `created_at` TIMESTAMP NULL,
                `updated_at` TIMESTAMP NULL
            ) $charsetCollate;";
            dbDelta($sql);
        }
    }
}
