<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
// Production: if (file_exists($maintenance = __DIR__.'/manager-app/storage/framework/maintenance.php')) {
if (file_exists($maintenance = __DIR__ . '/../storage/framework/maintenance.php'))
{
    require $maintenance;
}

// Register the Composer autoloader...
//production: require __DIR__.'/manager-app/vendor/autoload.php';
require __DIR__ . '/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
//production: $app = require_once __DIR__.'/manager-app/bootstrap/app.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$app->handleRequest(Request::capture());
