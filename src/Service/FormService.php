<?php

namespace Service;

use Entity\Example;
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

    public function buildStep1(Example $example)
    {
        $form = $this->formFactory->createBuilder('form', $example)
                    //Set Form info
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
