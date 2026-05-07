<?php

/**
 * Service: Util
 *
 * @package EMLOG
 * 
 */

class Util
{

    /**
     * Check if the application is running in development environment
     */
    public static function isDevEnv()
    {
        return getenv('EMLOG_ENV') === 'develop' || (defined('ENVIRONMENT') && ENVIRONMENT === 'develop');
    }

    /**
     * 构建带查询参数的 URL。
     *
     * @param string $path URL 路径
     * @param array $params 查询参数
     * @return string
     */
    public static function buildUrl($path, $params = array())
    {
        if (empty($params)) {
            return $path;
        }
        return $path . '?' . http_build_query($params);
    }

    /**
     * 写入一次性 Flash 消息。
     *
     * @param string $sessionKey Session 键名
     * @param string $messageKey 消息键名
     */
    public static function addFlashMessage($sessionKey, $messageKey)
    {
        if (empty($sessionKey) || empty($messageKey)) {
            return;
        }
        if (empty($_SESSION[$sessionKey]) || !is_array($_SESSION[$sessionKey])) {
            $_SESSION[$sessionKey] = array();
        }
        if (!in_array($messageKey, $_SESSION[$sessionKey])) {
            $_SESSION[$sessionKey][] = $messageKey;
        }
    }

    /**
     * 读取并消费一次性 Flash 消息。
     *
     * @param string $sessionKey Session 键名
     * @return array
     */
    public static function consumeFlashMessages($sessionKey)
    {
        $messages = isset($_SESSION[$sessionKey]) && is_array($_SESSION[$sessionKey]) ? $_SESSION[$sessionKey] : array();
        unset($_SESSION[$sessionKey]);
        return $messages;
    }

    /**
     * 跳转到指定 URL，并可选写入 Flash 消息。
     *
     * @param string $path URL 路径
     * @param array $params 查询参数
     * @param string $sessionKey Session 键名
     * @param string $messageKey 消息键名
     */
    public static function redirectWithFlash($path, $params = array(), $sessionKey = '', $messageKey = '')
    {
        if (!empty($sessionKey) && !empty($messageKey)) {
            self::addFlashMessage($sessionKey, $messageKey);
        }
        emDirect(self::buildUrl($path, $params));
    }
}
