<?php

use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();
$app->register(new DerAlex\Silex\YamlConfigServiceProvider(__DIR__ . '/src/Resources/config/settings.yml'));
$app['debug'] = $app['config']['debug'];

//TWIG
$app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/src/Resources/view/',
    ));
$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
    return $twig;
}));

$app->register(new SilexAssetic\AsseticServiceProvider());

$app['assetic.path_to_web'] = __DIR__ . '/assets';
$app['assetic.options'] = array(
    'debug' => $app['config']['debug'],
);
$app['assetic.filter_manager'] = $app['assetic.filter_manager'] = $app->share(
    $app->extend('assetic.filter_manager', function($fm, $app) {
        $fm->set('sass', new  Assetic\Filter\Sass\SassFilter(
            '/usr/local/bin/sass'
        ));

        return $fm;
    })
);
$app['assetic.asset_manager'] = $app->share(
    $app->extend('assetic.asset_manager', function($am, $app) {
        $am->set('styles', new Assetic\Asset\AssetCache(
            new Assetic\Asset\GlobAsset(
                __DIR__ . '/src/Resources/css/main.sass',
                array($app['assetic.filter_manager']->get('sass'))
            ),
            new Assetic\Cache\FilesystemCache(__DIR__ . '/cache/assetic')
        ));
        $am->get('styles')->setTargetPath('css/styles.css');

        return $am;
    })
);

$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'locale_fallback' => $app['config']['default_language'],
));


$app['translator'] = $app->share($app->extend('translator', function($translator, $app) {
    $translator->addLoader('yaml', new YamlFileLoader());

    foreach ($app['config']['languages'] as $language) {
        $translator->addResource('yaml', __DIR__.'/src/Resources/translations/'.$language.'.yml', $language);
    }

    return $translator;
}));

$app->register(new Silex\Provider\SessionServiceProvider());

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

//DATABASE
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => $app['config']['database']
));