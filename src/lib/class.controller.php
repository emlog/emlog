<?php
/**
 * 前端控制
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

class Controller {

	static $_instance;
	
	/**
	 * 请求模块
	 */
	private $_model;

	/**
	 * 请求模块方法
	 */
	private $_method;

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
			self::$_instance = new Controller();
			return self::$_instance;
		} else {
			return $_instance;
		}
    }

	private function __construct(){
		$this->_path = $this->setPath();
		$this->_routingTable = Option::getRoutingTable();

		foreach ($this->_routingTable as $route) {
			$reg = isset($route['reg_'.Option::get('isurlrewrite')]) ? 
			         $route['reg_'.Option::get('isurlrewrite')] : 
			         $route['reg'];
			if (preg_match($reg, $this->_path, $matches)) {
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
		return $path;
	}
}
