<?php

/**
 * Service: Template
 *
 * @package EMLOG
 * 
 */

class Template
{
    /**
     * 判断主题是否已启用
     *
     * @param string $template_alias 主题别名
     * @return bool
     */
    public static function isActive($template_alias)
    {
        $nonce_template = Option::get('nonce_templet');
        if (empty($nonce_template) || empty($template_alias)) {
            return false;
        }
        if ($template_alias === $nonce_template) {
            return true;
        }
        return false;
    }

    /**
     * 判断主题是否已安装
     *
     * @param string $template_alias 主题别名
     * @return bool
     */
    public static function isInstalled($template_alias)
    {
        if (empty($template_alias) || !preg_match('/^[\w\-]+$/', $template_alias)) {
            return false;
        }

        return is_dir(EMLOG_ROOT . '/content/templates/' . $template_alias);
    }

    /**
     * 获取当前使用的主题
     *
     * @return string
     */
    public static function getCurrentTemplate()
    {
        if (!defined('SWITCH_TEMPLATE') || SWITCH_TEMPLATE !== true) {
            return Option::get('nonce_templet');
        }

        $themeCookieName = 'emlog_theme';
        $theme = Input::getStrVar('theme');

        // 仅由字母、数字、下划线或连字符组成的字符串
        if ($theme && preg_match('/^[\w\-]+$/', $theme)) {
            setcookie($themeCookieName, $theme, time() + 86400, '/');
            return $theme;
        }

        // 如果没有传递theme参数，检查cookie
        if (isset($_COOKIE[$themeCookieName])) {
            $cookieTheme = $_COOKIE[$themeCookieName];
            if ($cookieTheme && preg_match('/^[\w\-]+$/', $cookieTheme)) {
                return $cookieTheme;
            }
        }

        return Option::get('nonce_templet');
    }
}
