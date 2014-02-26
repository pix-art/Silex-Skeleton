<?php

namespace ServiceProvider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Constraint\UniqueValidator;

/*
 * This is where we define the validator as a service
 */
class UniqueValidatorServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['validator.unique'] = $app->share(function ($app) {
            return new UniqueValidator($app['db']);
        });
    }

    public function boot(Application $app) {}
}
