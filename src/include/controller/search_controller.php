<?php
/**
 * 搜索文章
 *
 * @copyright (c) Emlog All Rights Reserved
 */

class Search_Controller {
	function display($params) {
		$Log_Model = new Log_Model();
		$options_cache = Option::getAll();
		extract($options_cache);

		$page = isset($params[4]) && $params[4] == 'page' ? abs(intval($params[5])) : 1;
		$keyword = isset($params[1]) && $params[1] == 'keyword' ? trim($params[2]) : '';
		$keyword = addslashes(htmlspecialchars(urldecode($keyword)));
		$keyword = str_replace(array('%', '_'), array('\%', '\_'), $keyword);

		$start_limit = ($page - 1) * $index_lognum;
		$pageurl = '';

		$sqlSegment = "and title like '%{$keyword}%' order by date desc";
		$lognum = $Log_Model->getLogNum('n', $sqlSegment);
		$pageurl .= BLOG_URL.'?keyword='.urlencode($keyword).'&page=';

		$logs = $Log_Model->getLogsForHome($sqlSegment, $page, $index_lognum);
		$page_url = pagination($lognum, $index_lognum, $page, $pageurl);

		include View::getView('header');
		include View::getView('log_list');
	}
}
