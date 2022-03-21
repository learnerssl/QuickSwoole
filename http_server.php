<?php
require './vendor/autoload.php';
require './app/Router/Web.php';

$http = new Swoole\Http\Server('0.0.0.0', 9527);

$router = new \QuickSwoole\Router();

$http->on('request', function ($request, $response) use ($router) {
    $router->handle($request, $response);

//    $response->header("Content-Type", "text/html; charset=utf-8");
//    $response->end("<h1>Hello Swoole. #" . rand(1000, 9999) . "</h1>");
});

$http->start();
