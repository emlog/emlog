<?php
/**
 * router
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Dispatcher {

	static $_instance;

	/**
	 * Request module
	 */
	private $_model = '';

	/**
	 * Request module method
	 */
	private $_method = '';

	/**
	 * Request parameters
	 */
	private $_params;

	/**
	 * Routing table
	 */
	private $_routingTable;

	/**
	 * path
	 */
	private $_path;

	public static function getInstance() {
		if (!self::$_instance instanceof self) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	private function __construct() {
		$this->_path = $this->setPath();
		$this->_routingTable = Option::getRoutingTable();

		$urlMode = Option::get('isurlrewrite');
		foreach ($this->_routingTable as $route) {
			$reg = $route['reg_' . $urlMode] ?? ($route['reg'] ?? $route['reg_0']);
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

		if (empty($this->_model)) {
			show_404_page();
		}
	}

	public function dispatch() {
		$module = new $this->_model();
		$method = $this->_method;
		$module->$method($this->_params);
	}

	public static function setPath() {
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
		if (isset($_SERVER['SERVER_SOFTWARE']) && false !== stristr($_SERVER['SERVER_SOFTWARE'], 'IIS')) {
			if (function_exists('mb_convert_encoding')) {
//vot				$path = mb_convert_encoding($path, 'UTF-8', 'GBK');
			} else {
//vot				$path = @iconv('GBK', 'UTF-8', @iconv('UTF-8', 'GBK', $path)) == $path ? $path : @iconv('GBK', 'UTF-8', $path);
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
