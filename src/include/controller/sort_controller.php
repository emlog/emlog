<?php
/**
 * 查看分类文章
 *
 * @copyright (c) Emlog All Rights Reserved
 */

class Sort_Controller {
	function display($params) {
		$Log_Model = new Log_Model();
		$CACHE = Cache::getInstance();
		$options_cache = Option::getAll();
		extract($options_cache);

		$page = isset($params[4]) && is_numeric($params[4]) ? abs(intval($params[4])) : 1;

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
			show_404_page();
		}
		$sort = $sort_cache[$sortid];
		$sortName = $sort['sortname'];
		//page meta
		$site_title = $sortName . ' - ' . $site_title;
		$site_description = !empty($sort_cache[$sortid]['description']) ? $sort_cache[$sortid]['description'] : $sort_cache[$sortid]['description'];
		if ($sort['pid'] != 0 || empty($sort['children'])) {
			$sqlSegment = "and sortid=$sortid";
		} else {
			$sortids = array_merge(array($sortid), $sort['children']);
			$sqlSegment = "and sortid in (" . implode(',', $sortids) . ")";
		}
		$sqlSegment .=  " order by date desc";
		$lognum = $Log_Model->getLogNum('n', $sqlSegment);
		$pageurl .= Url::sort($sortid, 'page');

		$logs = $Log_Model->getLogsForHome($sqlSegment, $page, $index_lognum);
		$page_url = pagination($lognum, $index_lognum, $page, $pageurl);

		include View::getView('header');
		include View::getView('log_list');
	}
}
