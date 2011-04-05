<?php
/**
 * 查看分类日志
 *
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

class Sort_Controller {

	/**
	 * 前台分类日志列表页面输出
	 */
	function display($params) {
		$Log_Model = new Log_Model();
		$CACHE = Cache::getInstance();
		$options_cache = $CACHE->readCache('options');
		extract($options_cache);
		$navibar = unserialize($navibar);
		$curpage = CURPAGE_HOME;

        $page = isset($params[4]) && $params[4] == 'page' ? abs(intval($params[5])) : 1;

		$sortid = '';
		if (!empty($params[2])) {
			if (is_numeric($params[2])) {
				$sortid = intval($params[2]);
			} else {
				$sort_cache = $CACHE->readCache('sort');
				foreach ($sort_cache as $key => $value) {
	        		$alias = addslashes(urldecode(trim($params[2])));
	        		if (array_search($alias, $value, true)){
	        			$sortid = $key;
	        			break;
	        		}
				}
			}
		}

		$start_limit = ($page - 1) * $index_lognum;
		$pageurl = '';

		$sort_cache = $CACHE->readCache('sort');
		if (!isset($sort_cache[$sortid])) {
			emMsg('不存在该分类', BLOG_URL);
		}
		$sortName = $sort_cache[$sortid]['sortname'];
        //page meta
		$blogtitle = $sortName.' - '.$blogname;
        $description = $bloginfo;
        $site_key .= ','.$sortName;

		$sqlSegment = "and sortid=$sortid order by date desc";
		$lognum = $Log_Model->getLogNum('n', $sqlSegment);
		$pageurl .= Url::sort($sortid, 'page');

		$logs = $Log_Model->getLogsForHome($sqlSegment, $page, $index_lognum);
		$page_url = pagination($lognum, $index_lognum, $page, $pageurl);

		include View::getView('header');
		include View::getView('log_list');
	}
}
