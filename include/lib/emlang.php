<?php

/**
 * Language support
 * @package EMLOG
 * @link https://www.emlog.net
 */

class EmLang
{
    private static $_instance         = null;
    private        $_currentLanguage  = 'zh_CN';
    private        $_langData         = [];
    private        $_langTemplateData = [];
    private        $_langPluginData   = [];

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
        $langFile = EMLOG_ROOT . '/content/languages/' . $this->_currentLanguage . '/' . $this->_currentLanguage . '.php';
        if (file_exists($langFile)) {
            $this->_langData = include $langFile;
        } else {
            $this->_langData = include EMLOG_ROOT . '/content/languages/zh_CN/zh_CN.php';
        }
    }

    public function loadTemplateLangFile()
    {
        $langFile = TEMPLATE_PATH . '/languages/' . $this->_currentLanguage . '/' . $this->_currentLanguage . '.php';
        if (file_exists($langFile)) {
            $this->_langTemplateData = include $langFile;
        }
    }

    public function loadPluginLangFile($pluginName = '')
    {
        if (!empty($pluginName)) {
            $langFile = PLUGIN_PATH . $pluginName . '/languages/' . $this->_currentLanguage . '/' . $this->_currentLanguage . '.php';
            if (file_exists($langFile)) {
                $this->_langPluginData = include $langFile;
            }
        }
    }

    public function get($key)
    {
        return isset($this->_langData[$key]) ? $this->_langData[$key] : $key;
    }

    public function getTpl($key)
    {
        $this->loadTemplateLangFile();
        return isset($this->_langTemplateData[$key]) ? $this->_langTemplateData[$key] : $key;
    }

    public function getPlu($key, $pluginName = '')
    {
        $this->loadPluginLangFile($pluginName);
        return isset($this->_langPluginData[$key]) ? $this->_langPluginData[$key] : $key;
    }

    public function currentLang()
    {
        return $this->_currentLanguage;
    }
}

function _lang($key)
{
    return EmLang::getInstance()->get($key);
}

function _langTpl($key)
{
    return EmLang::getInstance()->getTpl($key);
}

function _langPlu($key, $pluginName = '')
{
    return EmLang::getInstance()->getPlu($key, $pluginName);
}
