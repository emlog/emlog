<?php
/**
 * View author posts
 *
 * @copyright (c) Emlog All Rights Reserved
 */

class Author_Controller {

	/**
	 * Output of front-end author post list
	 */
	function display($params) {
		global $lang;
		$Log_Model = new Log_Model();
		$CACHE = Cache::getInstance();
		$options_cache = Option::getAll();
		extract($options_cache);
//Navigation bar
if(empty($navibar)) {
	$navibar = 'a:0:{}';
}
		$curpage = CURPAGE_HOME;

		$page = isset($params[4]) && $params[4] == 'page' ? abs(intval($params[5])) : 1;
		$author = isset($params[1]) && $params[1] == 'author' ? intval($params[2]) : '' ;

		$start_limit = ($page - 1) * $index_lognum;
		$pageurl = '';

		$user_cache = $CACHE->readCache('user');
		if (!isset($user_cache[$author])) {
			emMsg('404', BLOG_URL);
		}

		$author_name = $user_cache[$author]['name'];
		//page meta
		$site_title = $author_name . ' - ' . $site_title;

		$sqlSegment = "and author=$author order by date desc";
		$sta_cache = $CACHE->readCache('sta');
		$lognum = $sta_cache[$author]['lognum'];
		$pageurl .= Url::author($author, 'page');

		$Log_Model = new Log_Model();
		$logs = $Log_Model->getLogsForHome($sqlSegment, $page, $index_lognum);
		$page_url = pagination($lognum, $index_lognum, $page, $pageurl);

		include View::getView('header');
		include View::getView('log_list');
	}
}
