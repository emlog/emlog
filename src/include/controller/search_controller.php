<?php
/**
 * 查询日志
 *
 * @copyright (c) Emlog All Rights Reserved
 */

class Search_Controller {

	/**
	 * 前台查询日志列表页面输出
	 */
	function display($params) {
		$Log_Model = new Log_Model();
		$CACHE = Cache::getInstance();
		$options_cache = $CACHE->readCache('options');
		extract($options_cache);
		$navibar = unserialize($navibar);
		$curpage = CURPAGE_HOME;
		$description = $bloginfo;
		$blogtitle = $blogname;

		$page = isset($params[4]) && $params[4] == 'page' ? abs(intval($params[5])) : 1;
		$keyword = isset($params[1]) && $params[1] == 'keyword' ? addslashes(urldecode(trim($params[2]))) : '';

		$start_limit = ($page - 1) * $index_lognum;
		$pageurl = '';

		$keyword = str_replace('%','\%',$keyword);
		$keyword = str_replace('_','\_',$keyword);
		$sqlSegment = "and title like '%{$keyword}%' order by date desc";
		$lognum = $Log_Model->getLogNum('n', $sqlSegment);
		$pageurl .= BLOG_URL.'?keyword='.urlencode($keyword).'&page=';

		$logs = $Log_Model->getLogsForHome($sqlSegment, $page, $index_lognum);
		$page_url = pagination($lognum, $index_lognum, $page, $pageurl);

		include View::getView('header');
		include View::getView('log_list');
	}
}
