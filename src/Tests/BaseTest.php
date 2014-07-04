<?php

namespace Tests;

abstract class BaseTest extends \PHPUnit_Framework_TestCase
{
    protected $app;
    protected $connection;

    protected function setUp()
    {
        $this->app = $this->createApplication();
        $this->setConnection();
        $this->loadFixtures();
    }

    protected function setConnection()
    {
        $this->connection = $this->app['orm.em']->getConnection();
        $this->connection->connect();
        $this->connection->beginTransaction();
    }

    protected function tearDown()
    {
        $this->connection->rollback();
        $this->connection->close();
    }

    protected function createApplication()
    {
        $app = require __DIR__.'/../../bootstrap/bootstrap.php';
        $app['debug'] = true;
        $app['session.test'] = true;
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
