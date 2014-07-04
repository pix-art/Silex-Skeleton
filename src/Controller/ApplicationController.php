<?php
namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Entity\Example;

class ApplicationController
{

    public function indexAction(Request $request, Application $app)
    {
        return $app['twig']->render('index.html.twig', array());
    }

    public function step1Action(Request $request, Application $app)
    {
        $example = new Example();

        $form = $app['form_service']->buildStep1($example);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $example = $form->getData();
            $example->setLanguage($request->get('_locale'));
            $example->setIp($request->getClientIp());

            $app['orm.em']->persist($example);
            $app['orm.em']->flush();

            //$app['DatabaseService']->insert($example);
            return $app->redirect('...');
        }

        // display the form
        return $app['twig']->render('step1.html.twig', array('form' => $form->createView()));
    }

}
