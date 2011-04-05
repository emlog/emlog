<?php
/**
 * 查看作者日志
 *
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

class Author_Controller {

	/**
	 * 前台作者日志列表页面输出
	 */
	function display($params) {
		$Log_Model = new Log_Model();
		$CACHE = Cache::getInstance();
		$options_cache = $CACHE->readCache('options');
		extract($options_cache);
		$navibar = unserialize($navibar);
		$curpage = CURPAGE_HOME;

		$page = isset($params[4]) && $params[4] == 'page' ? abs(intval($params[5])) : 1;
		$author = isset($params[1]) && $params[1] == 'author' ? intval($params[2]) : '' ;

		$start_limit = ($page - 1) * $index_lognum;
		$pageurl = '';

		$user_cache = $CACHE->readCache('user');
		if (!isset($user_cache[$author])) {
			emMsg('不存在该作者', BLOG_URL);
		}

		$author_name = $user_cache[$author]['name'];
		//page meta
		$blogtitle = $author_name . ' - ' . $blogname;
		$description = $bloginfo;
		$site_key .= ','.$author_name;

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
