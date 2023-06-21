<?php

declare(strict_types=1);

use Hyperf\HttpServer\Router\Router;

Router::addServer('http', function () {
    require __DIR__ . '/routes/api.php';
    require __DIR__ . '/routes/openapi.php';
});