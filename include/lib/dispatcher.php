<?php

/**
 * router
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Dispatcher
{

    static $_instance;

    /**
     * Request module
     */
    public $_model = '';

    /**
     * Request module method
     */
    public $_method = '';

    /**
     * Request parameters
     */
    public $_params;

    /**
     * Routing table
     */
    private $_routingTable;

    /**
     * path
     */
    public $_path;

    public static function getInstance()
    {
        if (!self::$_instance instanceof self) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct()
    {
        $this->_path = $this->setPath();
        $this->_routingTable = Option::getRoutingTable();

        $urlMode = Option::get('isurlrewrite');
        foreach ($this->_routingTable as $route) {
            $reg = isset($route['reg_' . $urlMode]) ? $route['reg_' . $urlMode] : (isset($route['reg']) ? $route['reg'] : $route['reg_0']);
            if (preg_match($reg, $this->_path, $matches)) {
                $this->_model = $route['model'];
                $this->_method = $route['method'];
                $this->_params = $matches;

                // 优先考虑分类别名
                $alias = '';
                $param = $this->_params;
                if ($this->_model == 'Log_Controller' && $this->_method == 'displayContent') {
                    $alias = isset($param[1]) ? $param[1] : '';
                }
                if ($this->_model == 'Log_Controller' && $this->_method == 'display') {
                    $x = isset($param[0]) ? $param[0] : '';
                    if (preg_match("/\/([^\/]+)\/page\/\d+/", $x, $matches)) {
                        $alias = $matches[1];
                    }
                }
                if ($alias && $alias !== 'post') {
                    $Sort_Model = new Sort_Model();
                    $r = $Sort_Model->getSortByAlias($alias);
                    if ($r) {
                        $this->_model = 'Sort_Controller';
                        $this->_method = 'display';
                        $this->_params = ['/sort/' . $alias, 'sort', $alias];
                        $page = isset($param[2]) ? $param[2] : 0;
                        if ($page) {
                            $this->_params[3] = 'page/' . $page;
                            $this->_params[4] = 'page';
                            $this->_params[5] = $page;
                        }
                    }
                }

                // 设置页面为首页
                $homePageID = Option::get('home_page_id');
                if ($this->_model == 'Log_Controller' && $this->_method == 'display' && $homePageID && !strpos($this->_path, 'posts')) {
                    $this->_method = 'displayContent';
                    $this->_params = ['/?post=' . $homePageID, 'post', $homePageID];
                }
                break;
            }

            if (preg_match($route['reg_0'], $this->_path, $matches)) {
                $this->_model = $route['model'];
                $this->_method = $route['method'];
                $this->_params = $matches;
                break;
            }
        }

        if (empty($this->_model)) {
            show_404_page();
        }
    }

    public function dispatch()
    {
        $module = new $this->_model();
        $method = $this->_method;
        $module->$method($this->_params);
    }

    public static function setPath()
    {
        if (isset($_SERVER['HTTP_X_REWRITE_URL'])) { // for iis
            $path = $_SERVER['HTTP_X_REWRITE_URL'];
        } elseif (isset($_SERVER['REQUEST_URI'])) {
            $path = $_SERVER['REQUEST_URI'];
        } elseif (isset($_SERVER['argv'])) {
            $path = $_SERVER['PHP_SELF'] . '?' . $_SERVER['argv'][0];
        } else {
            $path = $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'];
        }

        //for iis6 path is GBK
        if (isset($_SERVER['SERVER_SOFTWARE']) && stripos($_SERVER['SERVER_SOFTWARE'], 'IIS') !== false) {
            if (function_exists('mb_convert_encoding')) {
                $path = mb_convert_encoding($path, 'UTF-8', 'GBK');
            } else {
                $path = @iconv('GBK', 'UTF-8', @iconv('UTF-8', 'GBK', $path)) == $path ? $path : @iconv('GBK', 'UTF-8', $path);
            }
        }
        //for ie6 header location
        $r = explode('#', $path, 2);
        $path = $r[0];
        //for iis6
        $path = str_ireplace('index.php', '', $path);
        //for subdirectory
        $t = parse_url(BLOG_URL);
        $path = str_replace($t['path'], '/', $path);

        return $path;
    }
}
