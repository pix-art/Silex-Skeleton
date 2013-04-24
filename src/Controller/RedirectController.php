<?php 
namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectController
{

    public function redirectAction(Request $request, Application $app, $path, $slugs)
    {	
	    return $app->redirect($app['url_generator']->generate($path, $slugs));
    }

}