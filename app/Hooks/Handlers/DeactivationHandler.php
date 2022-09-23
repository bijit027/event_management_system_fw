<?php

namespace EventManagementSystem\App\Hooks\Handlers;

use EventManagementSystem\Framework\Foundation\Application;

class DeactivationHandler
{
    protected $app = null;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }
    
    public function handle()
    {
        // ...
    }
}
