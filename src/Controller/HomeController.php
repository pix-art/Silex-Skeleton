<?php 
namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController
{

    public function indexAction(Request $request, Application $app)
    {	
        return $app['twig']->render('index.html.twig', array());
    }

}