<?php

$loader = require __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/database.php';
require_once __DIR__.'/general.php';

//SERVICES
$app['FormService'] = function ($app) {
    return new Service\FormService($app['form.factory'], $app['url_generator']);
};

$app['GeneralService'] = function ($app) {
    return new Service\GeneralService();
};

$app['FacebookService'] = function ($app) {
    return new Service\FacebookService($app['config']['facebook']['app_id'], $app['config']['facebook']['secret'], $app['config']['languages']);
};

return $app;
