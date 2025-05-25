<?php

/**
 * Service: Plugin
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Plugin
{

    public static function isActive($plugin_alias)
    {
        $active_plugins = Option::get('active_plugins');
        if (empty($active_plugins) || !is_array($active_plugins)) {
            return false;
        }
        foreach ($active_plugins as $plugin) {
            $parts = explode('/', $plugin);
            if (isset($parts[0]) && $parts[0] === $plugin_alias) {
                return true;
            }
        }
        return false;
    }
}
