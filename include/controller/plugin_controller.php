<?php

/**
 * loading plug-in page
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Plugin_Controller
{
    function loadPluginShow($params)
    {
        $plugin = isset($params[1]) && $params[1] == 'plugin' ? addslashes($params[2]) : '';
        if (!preg_match("/^[\w\-]+$/", $plugin)) {
            show_404_page();
        }
        if (Plugin::isActive($plugin) === false) {
            show_404_page();
        }
        if (!file_exists(EMLOG_ROOT . "/content/plugins/{$plugin}/{$plugin}_show.php")) {
            show_404_page();
        }
        include_once("./content/plugins/{$plugin}/{$plugin}_show.php");
    }
}
