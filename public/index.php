<?php

use Illuminate\Http\Request;
use OpenApi\Generator;

define('LARAVEL_START', microtime(true));
//error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
error_reporting(0);
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$openapi = Generator::scan([__DIR__ . '/../app/Http/Controllers']);
$openapi->toYaml();
$request = Request::capture();
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(Request::capture());
$response->send();
$kernel->terminate($request, $response);
