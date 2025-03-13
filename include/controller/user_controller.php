<?php

/**
 * user center
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class User_Controller
{
    function index($params)
    {
        if (!view::isTplExist('user')) {
            show_404_page();
        }

        $routerPath = '';
        $uc = Input::getStrVar('uc');
        if (!empty($params[2])) {
            $routerPath = $params[2];
        } else if (!empty($uc)) {
            $routerPath = $uc;
        }

        global $userData;
        $Log_Model = new Log_Model();
        $User_Model = new User_Model();

        $CACHE = Cache::getInstance();
        $options_cache = Option::getAll();
        extract($options_cache);

        include View::getView('user');
    }
}
