<?php

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/build.php';

//SERVICES
$app['TestService'] = function ($app) {
    return new Service\TestService($app['db']);
};


$app['current_url'] = $_SERVER['REQUEST_URI'];

$app->run();
