<?php

namespace EventManagementSystem\App\Hooks\Handlers;

use EventManagementSystem\Framework\Foundation\Application;
use EventManagementSystem\Database\DBMigrator;
use EventManagementSystem\Database\DBSeeder;

class ActivationHandler
{
    protected $app = null;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }
    
    public function handle($network_wide = false)
    {
        DBMigrator::run($network_wide);
        DBSeeder::run();
    }
}
