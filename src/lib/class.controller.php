<?php
/**
 * 前端控制
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

class Controller {
	
	static $_instance;
	private $_model;
	private $_method;
	private $_params;
    
	/**
	 * 路由表
	 * @var array
	 */
    private $_routingTable = array();

	/**
	 * 访问路径
	 * @var int
	 */
    private $_path = NULL;

    public static function getInstance() {
    	if(self::$_instance == null) {
    		self::$_instance = new Controller();
    		return self::$_instance;
    	} else {
    		return $_instance;
    	}
    }
    
    private function __construct(){

        $this->_path = $this->setPath();
        $this->_routingTable = Options::getRoutingTable();

        foreach ($this->_routingTable as $route) {
            if (preg_match($route['reg'], $this->_path, $matches)) {
            	$this->_model = $route['model'];
            	$this->_method = $route['method'];
            	$this->_params = $matches;
            }
        }
    }

    public function route(){
        $module = new $this->_model();
        $method = $this->_method;
        $module->$method($this->_params);
    }

    /**
     * 初始化路由
     */
    public static function initRouter($routingTable, $path=null) {
        self::setPath();
        self::$_routingTable = $routingTable;
    }


    /**
     * 设置路径
     */
    public static function setPath(){
        return $_SERVER['REQUEST_URI'];
        //print self::$_path;
    }

}