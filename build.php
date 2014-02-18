<?php
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader as YamlRouting;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\Request;
use Silex\Provider\FormServiceProvider;

$app = new Silex\Application();
$app->register(new DerAlex\Silex\YamlConfigServiceProvider(__DIR__ . '/src/Resources/config/settings.yml'));
$app['debug'] = $app['config']['debug'];

//TWIG
$app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/src/Resources/view/',
    ));
$app['twig'] = $app->share($app->extend('twig', function ($twig, $app) {
    return $twig;
}));

$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'locale_fallback' => $app['config']['default_language'],
));

$app['translator'] = $app->share($app->extend('translator', function ($translator, $app) {
    $translator->addLoader('yaml', new YamlFileLoader());

    foreach ($app['config']['languages'] as $language) {
        $translator->addResource('yaml', __DIR__.'/src/Resources/translations/'.$language.'.yml', $language);
    }

    return $translator;
}));

$app['routes'] = $app->extend('routes', function (RouteCollection $routes, $app) {
    $loader     = new YamlRouting(new FileLocator(__DIR__ . '/src/Resources/config'));
    $collection = $loader->load('routes.yml');
    $routes->addCollection($collection);

    return $routes;
});

$app->register(new Silex\Provider\SessionServiceProvider());

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app->register(new FormServiceProvider());

$app->register(new Silex\Provider\ValidatorServiceProvider());

//DATABASE
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => $app['config']['database']
));

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
