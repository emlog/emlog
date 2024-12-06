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
        if (!empty($params[2])) {
            $routerPath = $params[2];
        }

        global $userData;
        $Log_Model = new Log_Model();
        $User_Model = new User_Model();

        $CACHE = Cache::getInstance();
        $options_cache = Option::getAll();
        extract($options_cache);

        include View::getView('header');
        include View::getView('user');
    }
}
