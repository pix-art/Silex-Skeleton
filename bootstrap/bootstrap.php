<?php

$loader = require __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/database.php';
require_once __DIR__.'/general.php';

//SERVICES
$app['FormService'] = function ($app) {
    return new Service\FormService($app['form.factory'], $app['url_generator']);
};

return $app;
