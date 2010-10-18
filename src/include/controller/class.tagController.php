<?php
/**
 * 查看标签日志
 *
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

class TagController {

	/**
	 * 前台标签日志列表页面输出
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
		$tag = isset($params[1]) && $params[1] == 'tag' ? addslashes(urldecode(trim($params[2]))) : '';

		$start_limit = ($page - 1) * $index_lognum;
		$pageurl = '';

		$emTag = new emTag();
		$blogtitle = stripslashes($tag).' - '.$blogname;
		$blogIdStr = $emTag->getTagByName($tag);
		if ($blogIdStr === false) {
			emMsg('不存在该标签', BLOG_URL);
		}
		$sqlSegment = "and gid IN ($blogIdStr) order by date desc";
		$lognum = $emBlog->getLogNum('n', $sqlSegment);
		$pageurl .= Url::tag(urlencode($tag), 'page');

		$logs = $emBlog->getLogsForHome($sqlSegment, $page, $index_lognum);
		$page_url = pagination($lognum, $index_lognum, $page, $pageurl);

		include View::getView('header');
		include View::getView('log_list');
	}
}
