<?php

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/build.php';

//SERVICES
$app['ExampleService'] = function ($app) {
    return new Service\ExampleService($app['db']);
};

$app->run();
