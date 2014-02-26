<?php

$loader = require __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/bootstrap/config.php';
require_once __DIR__.'/bootstrap/database.php';
require_once __DIR__.'/bootstrap/general.php';

use Symfony\Component\HttpFoundation\Request;

//Before function to add global variables and much more to your request
$app->before(function (Request $request) use ($app) {
    //Flashbag

    /**
     * Add this in your controller
     * $app[ 'session' ]->set( 'flash', array(
     *               'type'    =>'error',
     *               'short'   =>'invalid_gift',
     *               'ext'     =>'The gift you selected is invalid',
     *           ));
     **/

    $flash = $app[ 'session' ]->get( 'flash' );
    $app[ 'session' ]->set( 'flash', null );

    if ( !empty( $flash ) ) {
        $app[ 'twig' ]->addGlobal( 'flash', $flash );
    }

    $app['twig']->addGlobal('current_route', str_replace('_', ' ', $request->get('_route')));
});

//SERVICES
$app['FormService'] = function ($app) {
    return new Service\FormService($app['form.factory'], $app['url_generator']);
};

$app->run();
