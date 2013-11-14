<?php 
namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Exceptions\ValidationException;
use Model\Example;

class ApplicationController
{

    public function indexAction(Request $request, Application $app)
    {	
        return $app['twig']->render('index.html.twig', array());
    }

    public function step1Action(Request $request, Application $app)
    {	 
        return $app['twig']->render('step1.html.twig');
    }

    public function step1PostAction(Request $request, Application $app)
    {	
    	try {

    		$data = $request->request->all();
    		$app['ExampleService']->validate($data);

            $test = new Example();
            //Set variables from post data in your model
    		$test->setVariable($data['variable']);

    		$app['ExampleService']->insert($test);
            
    	} catch (ValidationException $e) {
            $errors = $e->getErrors();
    		return $app['twig']->render('step1.html.twig', array('errors' => $errors, 'data' => $data));
    	}

    	//All was good you can now redirect to the right page
        //return $app->redirect($app['urlService']->generate('next_page', array()));
    }

}