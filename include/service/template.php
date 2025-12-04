<?php

/**
 * Service: Template
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Template
{

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
