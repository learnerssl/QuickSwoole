<?php

namespace App\Router;

use QuickSwoole\Router;

$router = new Router();
$router->setConfig([
    'namespace' => 'App\\Controller\\',
])->group(function () use ($router) {
    $router->get('/', 'IndexController@index');
    $router->get('/login', 'IndexController@login');
    $router->get('/user', 'UserController@index');
    $router->post('/user/loginSubmit', 'UserController@loginSubmit');
});
