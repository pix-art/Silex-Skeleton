<?php

namespace Tests;

use Entity\Example;

class FormServiceTest extends BaseTest
{

    protected function createFormService()
    {
        return $this->app['FormService'];
    }

    public function testBuildStep1()
    {
        $service = $this->createFormService();

        $form = $service->buildStep1($this->getTestObject());

        $this->assertInstanceOf('Symfony\Component\Form\Form', $form);

        $formData = $this->getTestData();

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());

        $this->assertEquals($this->getPopulatedTestObject(), $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }

    }

    protected function getTestData()
    {
        return array(
            'name' => 'John',
            'email' => 'John@example.com',
            'gender' => 'male',
        );
    }

    protected function getTestObject()
    {
        return new Example();
    }

    protected function getPopulatedTestObject()
    {
        $example = $this->getTestObject();
        $formData = $this->getTestData();

        foreach ($formData as $key => $value) {
            $ucfirst = ucfirst(strtolower($key));
            $name = 'set'.$ucfirst;

            if (method_exists($example, $name)) {
                $example->$name(utf8_encode($value));
            }
        }

        return $example;
    }
}
