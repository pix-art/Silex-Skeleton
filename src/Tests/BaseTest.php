<?php

namespace Tests;

use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

abstract class BaseTest extends \PHPUnit_Framework_TestCase
{
	protected $app;

	protected function setUp() {
		$this->app = $this->createApplication();
		$this->app['session.storage'] = new MockArraySessionStorage();
	}

  	protected function tearDown() {}

    protected function createApplication()
    {
        $app = require __DIR__.'/../../bootstrap/bootstrap.php';
        $app['debug'] = true;
        $app['exception_handler']->disable();

        return $app;
    }


}
