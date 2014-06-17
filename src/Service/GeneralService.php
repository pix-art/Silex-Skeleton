<?php

namespace Service;

class GeneralService {

    public function isMobile() {
        $user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);

        if(preg_match("/phone|iphone|itouch|ipod|symbian|android|htc_|htc-|palmos|blackberry|opera mini|iemobile|windows ce|nokia|fennec|hiptop|kindle|mot |mot-|webos\/|samsung|sonyericsson|^sie-|nintendo/", $user_agent)) {
            return true;
        } else if(preg_match("/mobile|pda;|avantgo|eudoraweb|minimo|netfront|brew|teleca|lg;|lge |wap;| wap /", $user_agent)) {
            return true;
        }

        return false;
    }

}
