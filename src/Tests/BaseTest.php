<?php

namespace Tests;

use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

abstract class BaseTest extends \PHPUnit_Framework_TestCase
{
    protected $app;

    protected function setUp()
    {
        $this->app = $this->createApplication();
        $this->app['db']->beginTransaction();
        $this->app['session.storage'] = new MockArraySessionStorage();
        $this->loadFixtures();
    }

    protected function tearDown()
    {
        $this->app['db']->rollback();
    }

    protected function createApplication()
    {
        $app = require __DIR__.'/../../bootstrap/bootstrap.php';
        $app['debug'] = true;
        $app['exception_handler']->disable();

        return $app;
    }

    protected function loadFixtures()
    {
        $loader = new \Nelmio\Alice\Loader\Yaml();
        $objects = $loader->load(__DIR__.'/files/fixtures.yml');

        $persister = new \Nelmio\Alice\ORM\Doctrine($this->app['orm.em']);
        $persister->persist($objects);
    }

}
