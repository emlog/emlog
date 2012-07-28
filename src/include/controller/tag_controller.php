<?php
/**
 * 查看标签日志
 *
 * @copyright (c) Emlog All Rights Reserved
 */

class Tag_Controller {

	/**
	 * 前台标签日志列表页面输出
	 */
	function display($params) {
		$Log_Model = new Log_Model();
		$options_cache = Option::getAll();
		extract($options_cache);
		$curpage = CURPAGE_HOME;

		$page = isset($params[4]) && $params[4] == 'page' ? abs(intval($params[5])) : 1;
		$tag = isset($params[1]) && $params[1] == 'tag' ? addslashes(urldecode(trim($params[2]))) : '';

		$start_limit = ($page - 1) * $index_lognum;
		$pageurl = '';

		//page meta
		$site_title = stripslashes($tag) . ' - ' . $site_title;

		$Tag_Model = new Tag_Model();
		$blogIdStr = $Tag_Model->getTagByName($tag);

		if ($blogIdStr === false) {
			emMsg('404', BLOG_URL);
		}
		$sqlSegment = "and gid IN ($blogIdStr) order by date desc";
		$lognum = $Log_Model->getLogNum('n', $sqlSegment);
		$pageurl .= Url::tag(urlencode($tag), 'page');

		$logs = $Log_Model->getLogsForHome($sqlSegment, $page, $index_lognum);
		$page_url = pagination($lognum, $index_lognum, $page, $pageurl);

		include View::getView('header');
		include View::getView('log_list');
	}
}
