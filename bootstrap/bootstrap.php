<?php

$loader = require __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/database.php';
require_once __DIR__.'/general.php';

//SERVICES
$app['form_service'] = function ($app) {
    return new Service\FormService($app['form.factory'], $app['url_generator']);
};

$app['general_service'] = function ($app) {
    return new Service\GeneralService();
};

$app['facebook_service'] = function ($app) {
    return new Service\FacebookService($app['config']['facebook']['app_id'], $app['config']['facebook']['secret'], $app['config']['languages']);
};

return $app;
