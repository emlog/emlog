<?php

/**
 * Language support
 * @package EMLOG
 * @link https://www.emlog.net
 */

class EmLang
{
    private static $_instance = null;
    private $_currentLanguage = 'zh_CN';
    private $_langData = [];

    private function __construct()
    {
        $this->init();
    }

    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function init()
    {
        // Default to Chinese (zh_CN) if not configured
        $lang = 'zh_CN';
        if (defined('EMLOG_LANG')) {
            $lang = EMLOG_LANG;
        }

        $this->_currentLanguage = $lang;
        $this->loadLangFile();
    }

    private function loadLangFile()
    {
        $langFile = EMLOG_ROOT . '/content/languages/' . $this->_currentLanguage . '.php';
        if (file_exists($langFile)) {
            $this->_langData = include $langFile;
        } else {
            $this->_langData = include EMLOG_ROOT . '/content/languages/zh_CN.php';
        }
    }

    public function get($key)
    {
        return isset($this->_langData[$key]) ? $this->_langData[$key] : $key;
    }

    public function currentLang()
    {
        return $this->_currentLanguage;
    }
}

/**
 * Display translated string
 */
function _lang($key)
{
    echo EmLang::getInstance()->get($key);
}

/**
 * Return translated string
 */
function __($key)
{
    return EmLang::getInstance()->get($key);
}
