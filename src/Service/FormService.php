<?php

namespace Service;

use Model\Example;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Routing\Generator\UrlGenerator;

class FormService
{
    private $formFactory;
    private $urlGenerator;

    public function __construct(FormFactory $formFactory, UrlGenerator $urlGenerator)
    {
        $this->formFactory = $formFactory;
        $this->urlGenerator = $urlGenerator;
    }

    public function buildStep1()
    {
        //Set model + default values
        $example = new Example();
        $example->setName('Your name');

        $form = $this->formFactory->createBuilder('form', $example)
                    //Set Form info
                    ->setAction($this->urlGenerator->generate('step1'))
                    ->setMethod('POST')
                    //Set fields
                    ->add('name', 'text')
                    ->add('email', 'email')
                    ->add('gender', 'choice', array(
                            'choices' => array('male' => 'male', 'female' => 'female'),
                            'expanded' => true
                        ))
                    //Set buttons
                    ->add('save', 'submit')
                    //Fetch form
                    ->getForm();

        return $form;
    }

}
