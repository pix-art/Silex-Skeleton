<?php
namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class ApplicationController
{

    public function indexAction(Request $request, Application $app)
    {
        return $app['twig']->render('index.html.twig', array());
    }

    public function step1Action(Request $request, Application $app)
    {

        $form = $app['FormService']->build();
        $form->handleRequest($request);

        if ($form->isValid()) {

            $example = $form->getData();

            $app['DatabaseService']->insert($example);

            return $app->redirect('...');
        }

        // display the form
        return $app['twig']->render('step1.html.twig', array('form' => $form->createView()));
    }

}
