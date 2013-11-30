<?php
/**
 * 查看作者文章
 *
 * @copyright (c) Emlog All Rights Reserved
 */

class Author_Controller {
	function display($params) {
		$Log_Model = new Log_Model();
		$CACHE = Cache::getInstance();
		$options_cache = Option::getAll();
		extract($options_cache);

		$page = isset($params[4]) && $params[4] == 'page' ? abs(intval($params[5])) : 1;
		$author = isset($params[1]) && $params[1] == 'author' ? intval($params[2]) : '' ;

		
		$pageurl = '';

		$user_cache = $CACHE->readCache('user');
		if (!isset($user_cache[$author])) {
			show_404_page();
		}

		$author_name = $user_cache[$author]['name'];
		//page meta
		$site_title = $author_name . ' - ' . $site_title;

		$sqlSegment = "and author=$author order by date desc";
		$sta_cache = $CACHE->readCache('sta');
		$lognum = $sta_cache[$author]['lognum'];
        
        $total_pages = ceil($lognum / $index_lognum);
        if ($page > $total_pages) {
            $page = $total_pages;
        }
        $start_limit = ($page - 1) * $index_lognum;
		$pageurl .= Url::author($author, 'page');

		$Log_Model = new Log_Model();
		$logs = $Log_Model->getLogsForHome($sqlSegment, $page, $index_lognum);
		$page_url = pagination($lognum, $index_lognum, $page, $pageurl);

		include View::getView('header');
		include View::getView('log_list');
	}
}
