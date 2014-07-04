<?php

namespace Service;

use Facebook\FacebookPageTabHelper;
use Facebook\FacebookSession;
use Facebook\FacebookCanvasLoginHelper;

class FacebookService {

    private $locales;

    public function __construct($appId, $appSecret, $locales)
    {
        $this->locales = $locales;
        FacebookSession::setDefaultApplication($appId, $appSecret);
    }

    public function isLiked()
    {
        $appHelper = new FacebookPageTabHelper();
        return $appHelper->isLiked();
    }

    /**
    * Dirty explode on signed request to retrieve user language. 
    * This will be depricated soon. Enjoy it while it lasts
    **/    
    public function getCurrentLanguage($default = 'nl')
    {
        $locale = $default;

        if (isset($_REQUEST["signed_request"])) {
            $signed_request = $_REQUEST["signed_request"];  
            list($encoded_sig, $payload) = explode('.', $signed_request, 2);
            $data = json_decode(base64_decode(strtr($payload, '-_', '+/')), true);
            $localeArray = explode('_', $data["user"]["locale"]);
            $fblocale = $localeArray[0];
            
            if (in_array($fblocale , $this->locales)) {
                $locale = $fblocale;
            }
        }

        return $locale;
    }


}
