<?php

$app = new Silex\Application();
$app->register(new DerAlex\Silex\YamlConfigServiceProvider(__DIR__ . '/../src/Resources/config/settings.yml'));
$app['debug'] = $app['config']['debug'];
