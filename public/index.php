<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
if (file_exists(__DIR__.'/../vendor/autoload.php')) {
    require __DIR__.'/../vendor/autoload.php';
}

// Bootstrap Laravel and handle the request...
if (file_exists(__DIR__.'/../bootstrap/app.php')) {
    /** @var \Illuminate\Foundation\Application $app */
    $app = require_once __DIR__.'/../bootstrap/app.php';
    $app->handleRequest(Request::capture());
} else {
    // Graceful DirectAdmin landing indicator if composer install is pending
    echo "<!DOCTYPE html><html><head><title>Paperglow Kenya</title><style>body{font-family:sans-serif;padding:40px;background:#f8fafc;color:#0f172a;}h1{color:#dc2626;}code{background:#e2e8f0;padding:2px 6px;border-radius:4px;}</style></head><body>";
    echo "<h1>Paperglow — Laravel 11 & PHP 8.3 Ready</h1>";
    echo "<p>Paperglow is configured for Shujaa Host / DirectAdmin.</p>";
    echo "<p>Next step: run <code>composer install --no-dev</code> in your domain root via SSH.</p>";
    echo "</body></html>";
}
