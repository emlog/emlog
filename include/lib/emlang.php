<?php

/**
 * Language support
 * @package EMLOG
 * @link https://www.emlog.net
 */

class EmLang
{
    const DEFAULT_LANGUAGE            = 'zh_CN';
    private static $_instance         = null;
    private        $_currentLanguage  = self::DEFAULT_LANGUAGE;
    private        $_langData         = [];
    private        $_langJsData         = [];
    private        $_langTemplateData = [];
    private        $_langPluginData   = [];
    private        $_langInstallData   = [];

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
        $langFile = EMLOG_ROOT . '/content/languages/' . $this->_currentLanguage . '/main.php';
        if (file_exists($langFile)) {
            $this->_langData = include $langFile;
        } else {
            $this->_langData = include EMLOG_ROOT . '/content/languages/' . self::DEFAULT_LANGUAGE . '/main.php';
        }
        $langFile = EMLOG_ROOT . '/content/languages/' . $this->_currentLanguage . '/main_js.php';
        if (file_exists($langFile)) {
            $this->_langJsData = include $langFile;
        } else {
            $this->_langJsData = include EMLOG_ROOT . '/content/languages/' . self::DEFAULT_LANGUAGE . '/main_js.php';
        }
    }

    public function loadTemplateLang()
    {
        $langFile = TEMPLATE_PATH . '/languages/' . $this->_currentLanguage . '/main.php';
        if (file_exists($langFile)) {
            $this->_langTemplateData = include $langFile;
        } else {
            $langFile = TEMPLATE_PATH . '/languages/' . self::DEFAULT_LANGUAGE . '/main.php';
            if (file_exists($langFile)) {
                $this->_langTemplateData = include $langFile;
            }
        }
    }

    public function loadPluginLang($pluginName = '')
    {
        if (!empty($pluginName)) {
            $langFile = PLUGIN_PATH . $pluginName . '/languages/' . $this->_currentLanguage . '/main.php';
            if (file_exists($langFile)) {
                $this->_langPluginData = include $langFile;
            } else {
                $langFile = PLUGIN_PATH . $pluginName . '/languages/' . self::DEFAULT_LANGUAGE . '/main.php';
                if (file_exists($langFile)) {
                    $this->_langPluginData = include $langFile;
                }
            }
        }
    }

    public function loadInstallLang($lang = self::DEFAULT_LANGUAGE)
    {
        $this->_currentLanguage = $lang;
        $langFile = EMLOG_ROOT . '/content/languages/' . $this->_currentLanguage . '/install.php';
        if (file_exists($langFile)) {
            $this->_langInstallData = include $langFile;
        } else {
            $langFile = EMLOG_ROOT . '/content/languages/' . self::DEFAULT_LANGUAGE . '/install.php';
            if (file_exists($langFile)) {
                $this->_langInstallData = include $langFile;
            }
        }
    }

    public function get($key)
    {
        return isset($this->_langData[$key]) ? $this->_langData[$key] : $key;
    }

    public function getTpl($key)
    {
        $this->loadTemplateLang();
        return isset($this->_langTemplateData[$key]) ? $this->_langTemplateData[$key] : $key;
    }

    public function getPlu($key, $pluginName = '')
    {
        $this->loadPluginLang($pluginName);
        return isset($this->_langPluginData[$key]) ? $this->_langPluginData[$key] : $key;
    }

    public function getInstall($key)
    {
        return isset($this->_langInstallData[$key]) ? $this->_langInstallData[$key] : $key;
    }

    public function currentLang()
    {
        return $this->_currentLanguage;
    }

    public function getJsLang()
    {
        return $this->_langJsData;
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

function _langInstall($key)
{
    return EmLang::getInstance()->getInstall($key);
}
