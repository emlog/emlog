<?php
/**
 * Rest API controller
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Api_Controller {

	/**
	 * starter
	 */
	function starter($params) {

		if (empty($params[1]) || $params[1] != 'rest-api' || empty($_GET['rest-api'])) {
			show_404_page();
		}

		$_func = $_GET['rest-api'];

		if (method_exists($this, $_func)) {
			$this->$_func();
		} else {
			show_404_page();
		}

	}

	private function article_getlist() {
		$Log_Model = new Log_Model();
		$CACHE = Cache::getInstance();

		$page = isset($params[1]) && $params[1] == 'page' ? abs((int)$params[2]) : 1;
		$index_lognum = 20;

		$sqlSegment = 'ORDER BY top DESC ,date DESC';
		$sta_cache = $CACHE->readCache('sta');
		$logs = $Log_Model->getLogsForHome($sqlSegment, $page, $index_lognum);

		Output::ok($logs);
	}

}
