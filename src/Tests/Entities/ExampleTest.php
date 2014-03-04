<?php

namespace Tests;

use Entity\Example;

class ExampleTest extends BaseTest
{

    protected function getValidator()
    {
        return $this->app['validator'];
    }

    public function testCorrectData()
    {
        $example = $this->getPopulatedTestObject();

        $errors = $this->getValidator()->validate($example);

        $this->assertEquals(0, count($errors));
    }

    public function testBadData()
    {
        $example = $this->getPopulatedTestObject();

        $errors = $this->getValidator()->validate($example);

        $this->assertEquals(1, $errors->count());
        $this->assertEquals('client not valid', $errors[0]->getMessage());
    }

    protected function getTestData()
    {
        return array(
            'name' => 'JohnDoe',
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
