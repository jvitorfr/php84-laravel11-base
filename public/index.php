<?php

use Illuminate\Http\Request;
use OpenApi\Generator;

define('LARAVEL_START', microtime(true));


//error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
error_reporting(0);

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap the Laravel application...
$app = require_once __DIR__.'/../bootstrap/app.php';

// Gerar documentação OpenAPI
$openapi = Generator::scan([__DIR__ . '/../app/Http/Controllers']);

//header('Content-Type: application/x-yaml');
$openapi->toYaml();


$request = Request::capture();

// Handle the request...
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(Request::capture());


$response->send();

// Terminate the application
$kernel->terminate($request, $response);
