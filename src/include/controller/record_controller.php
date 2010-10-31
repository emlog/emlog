<?php
/**
 * 查看归档日志
 *
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

class Record_Controller {

	/**
	 * 前台归档日志列表页面输出
	 */
	function display($params) {
		$Log_Model = new Log_Model();
		$CACHE = Cache::getInstance();
		$options_cache = $CACHE->readCache('options');
		extract($options_cache);
		$navibar = unserialize($navibar);
		$curpage = CURPAGE_HOME;

		$page = isset($params[4]) && $params[4] == 'page' ? abs(intval($params[5])) : 1;
		$record = isset($params[1]) && $params[1] == 'record' ? intval($params[2]) : '' ;

		$start_limit = ($page - 1) * $index_lognum;
		$pageurl = '';

		//page meta
		$blogtitle = $record.' - '.$blogname;
        $description = $bloginfo;

		if (preg_match("/^([\d]{4})([\d]{2})$/", $record, $match)) {
			$days = getMonthDayNum($match[2], $match[1]);
			$record_stime = emStrtotime($record . '01');
			$record_etime = $record_stime + 3600 * 24 * $days;
		} else {
			$record_stime = emStrtotime($record);
			$record_etime = $record_stime + 3600 * 24;
		}
		$sqlSegment = "and date>=$record_stime and date<$record_etime order by top desc ,date desc";
		$lognum = $Log_Model->getLogNum('n', $sqlSegment);
		$pageurl .= Url::record($record, 'page');

		$logs = $Log_Model->getLogsForHome($sqlSegment, $page, $index_lognum);
		$page_url = pagination($lognum, $index_lognum, $page, $pageurl);

		include View::getView('header');
		include View::getView('log_list');
	}
}
