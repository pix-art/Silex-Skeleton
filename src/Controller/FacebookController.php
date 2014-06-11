<?php
namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;

class FacebookController
{

    public function fangateAction(Request $request, Application $app)
    {   
        $locale = $app['config']['default_language'];

        // Dirty fix for safari that doesn't allow you to start a session via an iframe if you find a better solution feel free
        // if (!$request->cookies->has('cookie_fix')) {
        //     die('<script type="text/javascript">window.top.location = "' . $app['url_generator']->generate('facebook_redirect', array(), true) . '"</script>');
        // }

        if ($app['FacebookService']->isLiked()) {
            
            $locale = $app['FacebookService']->getCurrentLanguage($locale);

            return $app->redirect($app['url_generator']->generate($app['config']['facebook']['start_route'], array('_locale' => $locale)));
        }    

        return $app['twig']->render('nofan.html.twig', array('locale' => $locale));
    }

    public function redirectAction(Request $request, Application $app)
    {   
        if($app['GeneralService']->isMobile()) {
            $locale = $app['config']['default_language'];
            $url = $app['url_generator']->generate($app['config']['facebook']['start_route'], array('_locale' => $locale));
            return $app->redirect($url);
        }
        
        $cookie = new Cookie('cookie_fix', true);
        $response = $app->redirect($app['config']['facebook']['tab']);
        $response->headers->setCookie($cookie);
        return $response;
    }

}
