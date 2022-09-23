<?php

namespace EventManagementSystem\Database;

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

use EventManagementSystem\Database\Migrations\BikeMigrator;

// class DBMigrator
// {
//     public static function run($network_wide = false)
//     {
//         BikeMigrator::migrate();
//     }
// }

class DBMigrator
{
    protected static $migrators = [
        BikeMigrator::class,
    ];
    public static function run($network_wide = false)
    {
        self::migrate();
    }

    public static function migrate()
    {
        foreach (static::$migrators as $class) {
            $class::migrate();
        }
    }
}
