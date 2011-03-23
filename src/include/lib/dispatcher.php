<?php
/**
 * 路由分发器
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

class Dispatcher {

    static $_instance;
    
    /**
     * 请求模块
     */
    private $_model = 'Log_Controller';

    /**
     * 请求模块方法
     */
    private $_method = 'display';

    /**
     * 请求参数
     */
    private $_params;

    /**
     * 路由表
     */
    private $_routingTable;

    /**
     * 访问路径
     */
    private $_path = NULL;

    public static function getInstance() {
        if(self::$_instance == null) {
            self::$_instance = new Dispatcher();
            return self::$_instance;
        } else {
            return $_instance;
        }
    }

    private function __construct() {
        $this->_path = $this->setPath();
        $this->_routingTable = Option::getRoutingTable();

        $urlMode = Option::get('isurlrewrite');

        foreach ($this->_routingTable as $route) {
            if (!isset($route['reg_' . $urlMode])) {
            	$reg = isset($route['reg']) ? $route['reg'] :$route['reg_0'];
            } else {
            	$reg = $route['reg_' . $urlMode];
            }
            if (preg_match($reg, $this->_path, $matches)) {
                $this->_model = $route['model'];
                $this->_method = $route['method'];
                $this->_params = $matches;
                break;
            } elseif (preg_match($route['reg_0'], $this->_path, $matches)) {
                $this->_model = $route['model'];
                $this->_method = $route['method'];
                $this->_params = $matches;
                break;
            }
        }
    }

    public function dispatch(){
        $module = new $this->_model();
        $method = $this->_method;
        $module->$method($this->_params);
    }

    public static function setPath(){
        $path = '';
        if (isset($_SERVER['REQUEST_URI'])){
            $path = $_SERVER['REQUEST_URI'];
        } else {
            if (isset($_SERVER['argv'])) {
                $path = $_SERVER['PHP_SELF'] .'?'. $_SERVER['argv'][0];
            } else {
                $path = $_SERVER['PHP_SELF'] .'?'. $_SERVER['QUERY_STRING'];
            }
        }
        //for iis6
        $path = str_replace('index.php', '', $path);
        //for subdirectory
        $t = parse_url(BLOG_URL);
        $path = str_replace($t['path'], '/', $path);
        return $path;
    }
}
