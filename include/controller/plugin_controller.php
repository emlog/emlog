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
            return;
        }
        if (Plugin::isActive($plugin) === false) {
            return;
        }
        if (!file_exists(EMLOG_ROOT . "/content/plugins/{$plugin}/{$plugin}_show.php")) {
            return;
        }
        include_once("./content/plugins/{$plugin}/{$plugin}_show.php");
    }
}
