<?php

namespace Tests;

abstract class BaseTest extends \PHPUnit_Framework_TestCase
{
    public function createApplication()
    {
        $app = require __DIR__.'/../../bootstrap/bootstrap.php';
        $app['debug'] = true;
        $app['exception_handler']->disable();

        return $app;
    }
}
