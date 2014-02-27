<?php

namespace Tests;

use Entity\Example;

class FormServiceTest extends BaseTest
{

    public function createFormService()
    {
        $app = $this->createApplication();

        return $app['FormService'];
    }

    public function testBuildStep1()
    {
        $service = $this->createFormService();

        $example = new Example();

        $form = $service->buildStep1($example);

        $this->assertInstanceOf('Symfony\Component\Form\Form', $form);
    }
}
