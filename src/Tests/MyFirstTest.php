<?php

namespace Tests;

use Silex\WebTestCase;

class MyFirstTest extends WebTestCase
{
    public function createApplication()
    {
        return require __DIR__.'/../../index.php';
    }

    public function testFooBar()
    {
        $this->assertTrue(false);
    }
}
