<?php

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/build.php';

//SERVICES
$app['TestService'] = function ($app) {
    return new Service\TestService($app['db']);
};


$app['current_url'] = $_SERVER['REQUEST_URI'];



//ROUTES
$app->get('/', function () use ($app) {
    return $app->redirect($app['url_generator']->generate('home', array('_locale' => 'nl')));
})
->bind('start');

$app->get('/fr', function () use ($app) {
    return $app->redirect($app['url_generator']->generate('home', array('_locale' => 'fr')));
})
->bind('start_fr');


$app->run();
