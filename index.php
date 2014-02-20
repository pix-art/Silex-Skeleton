<?php

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/build.php';

//SERVICES
$app['FormService'] = function ($app) {
    return new Service\FormService($app['form.factory'], $app['url_generator']);
};

$app['DatabaseService'] = function ($app) {
    return new Service\DatabaseService($app['db'], $app['config']['database']['dbname']);
};

$app->run();
