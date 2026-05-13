<?php

/**
 * Service: Plugin
 *
 * @package EMLOG
 * 
 */

class Plugin
{
    /**
     * 判断插件是否已启用
     *
     * @param string $plugin_alias 插件别名
     * @return bool
     */
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

    /**
     * 判断插件是否已安装
     *
     * @param string $plugin_alias 插件别名
     * @return bool
     */
    public static function isInstalled($plugin_alias)
    {
        if (empty($plugin_alias) || !preg_match('/^[\w\-]+$/', $plugin_alias)) {
            return false;
        }

        return is_dir(EMLOG_ROOT . '/content/plugins/' . $plugin_alias);
    }
}
