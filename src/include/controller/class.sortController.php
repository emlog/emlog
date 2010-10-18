<?php
/**
 * 查看分类日志
 *
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

class SortController {

	/**
	 * 前台分类日志列表页面输出
	 */
	function display($params) {
		$emBlog = new emBlog();
		$CACHE = Cache::getInstance();
		$options_cache = $CACHE->readCache('options');
		extract($options_cache);
		$navibar = unserialize($navibar);
		$curpage = CURPAGE_HOME;
		$blogtitle = $blogname;

        $page = isset($params[4]) && $params[4] == 'page' ? abs(intval($params[5])) : 1;
		$sortid = isset($params[1]) && $params[1] == 'sort' ? intval($params[2]) : '' ;

		$start_limit = ($page - 1) * $index_lognum;
		$pageurl = '';

		$sort_cache = $CACHE->readCache('sort');
		if (!isset($sort_cache[$sortid])) {
			emMsg('不存在该分类', BLOG_URL);
		}
		$sortName = $sort_cache[$sortid]['sortname'];
		$blogtitle = $sortName.' - '.$blogname;
		$sqlSegment = "and sortid=$sortid order by date desc";
		$lognum = $emBlog->getLogNum('n', $sqlSegment);
		$pageurl .= Url::sort($sortid, 'page');

		$logs = $emBlog->getLogsForHome($sqlSegment, $page, $index_lognum);
		$page_url = pagination($lognum, $index_lognum, $page, $pageurl);

		include View::getView('header');
		include View::getView('log_list');
	}
}
