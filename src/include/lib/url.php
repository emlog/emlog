<?php
/**
 * URL processing
 * @copyright (c) Emlog All Rights Reserved
 */

class Url {

	/**
         * Get post link
	 */
	static function log($blogId) {
		$urlMode = Option::get('isurlrewrite');
		$logUrl = '';
		$CACHE = Cache::getInstance();

        	//Turn on post url  alias
		if (Option::get('isalias') == 'y') {
			$logalias_cache = $CACHE->readCache('logalias');
			if (!empty($logalias_cache[$blogId])) {
				$logsort_cache = $CACHE->readCache('logsort');
				$sort = '';
            			//Url in category mode
				if (3 == $urlMode && isset($logsort_cache[$blogId])) {
					$sort = !empty($logsort_cache[$blogId]['alias']) ? 
						$logsort_cache[$blogId]['alias'] : 
						$logsort_cache[$blogId]['name'];
					$sort .= '/';
				}
				$logUrl = BLOG_URL . $sort . urlencode($logalias_cache[$blogId]);
                		//Add html suffix to the alias
				if (Option::get('isalias_html') == 'y') {
					$logUrl .= '.html';
				}
				return $logUrl;
			}
		}

		switch ($urlMode) {
            		case '0'://Default: dynamic
				$logUrl = BLOG_URL . '?post=' . $blogId;
				break;
            		case '1'://Static
				$logUrl = BLOG_URL . 'post-' . $blogId . '.html';
				break;
            		case '2'://Directory
				$logUrl = BLOG_URL . 'post/' . $blogId;
				break;
            		case '3'://Category
				$log_sort = $CACHE->readCache('logsort');
				if (!empty($log_sort[$blogId]['alias'])) {
					$logUrl = BLOG_URL . $log_sort[$blogId]['alias'] . '/' . $blogId;
				} elseif(!empty($log_sort[$blogId]['name'])) {
					$logUrl = BLOG_URL . $log_sort[$blogId]['name'] . '/' . $blogId;
				} else {
					$logUrl = BLOG_URL . $blogId;
				}
				$logUrl .= '.html';
				break;
		}
		return $logUrl;
	}

	/**
         * Get archive link
	 */
	static function record($record, $page = null) {
		$recordUrl = '';
		switch (Option::get('isurlrewrite')) {
			case '0':
				$recordUrl = BLOG_URL . '?record=' . $record;
				if ($page)
					$recordUrl .= '&page=';
				break;
			default:
				$recordUrl = BLOG_URL . 'record/' . $record;
				if ($page)
					$recordUrl = BLOG_URL . 'record/' . $record . '/page/';
				break;
		}
		return $recordUrl;
	}

	/**
         * Get category link
	 */
	static function sort($sortId, $page = null) {
		$CACHE = Cache::getInstance();
		$sort_cache = $CACHE->readCache('sort');
		$sort_index = !empty($sort_cache[$sortId]['alias']) ? $sort_cache[$sortId]['alias'] : $sortId;
		$sortUrl = '';
		switch (Option::get('isurlrewrite')) {
			case '0':
				$sortUrl = BLOG_URL . '?sort=' . $sortId;
				if ($page)
					$sortUrl .= '&page=';
				break;
			default:
				$sortUrl = BLOG_URL . 'sort/' . $sort_index;
				if ($page)
					$sortUrl = BLOG_URL . 'sort/' . $sort_index . '/page/';
				break;
		}
		return $sortUrl;
	}

	/**
         * Get author link
	 */
	static function author($authorId, $page = null) {
		$authorUrl = '';
		switch (Option::get('isurlrewrite')) {
			case '0':
				$authorUrl = BLOG_URL . '?author=' . $authorId;
				if ($page)
					$authorUrl .= '&page=';
				break;
			default:
				$authorUrl = BLOG_URL . 'author/' . $authorId;
				if ($page)
					$authorUrl = BLOG_URL . 'author/' . $authorId . '/page/';
				break;
		}
		return $authorUrl;
	}

	/**
         * Get tag link
	 */
	static function tag($tag, $page = null) {
		$tagUrl = '';
		switch (Option::get('isurlrewrite')) {
			case '0':
				$tagUrl = BLOG_URL . '?tag=' . $tag;
				if ($page)
					$tagUrl .= '&page=';
				break;
			default:
				$tagUrl = BLOG_URL . 'tag/' . $tag;
				if ($page)
					$tagUrl = BLOG_URL . 'tag/' . $tag . '/page/';
				break;
		}
		return $tagUrl;
	}

	/**
         * Get the page link
	 */
	static function logPage() {
		$logPageUrl = '';
		switch (Option::get('isurlrewrite')) {
			case '0':
				$logPageUrl = BLOG_URL . '?page=';
				break;
			default:
				$logPageUrl = BLOG_URL . 'page/';
				break;
		}
		return $logPageUrl;
	}

	/**
         * Get comment link
	 */
	static function comment($blogId, $pageId, $cid) {
		$commentUrl = Url::log($blogId);
		if ($pageId > 1) {
			if (Option::get('isurlrewrite') == 0 && strpos($commentUrl, '=') !== false) {
				$commentUrl .= '&comment-page=';
			} else {
				$commentUrl .= '/comment-page-';
			}
			$commentUrl .= $pageId;
		}
		$commentUrl .= '#' . $cid;
		return $commentUrl;
	}

	/**
	 * 获取评论链接
	 */
	static function navi($type, $typeId, $url) {
        $sorts = Cache::getInstance()->readCache('sort');
		switch ($type) {
			//常规导航
			case 0:
				$url = $url;
				break;
			//系统默认，包括首页，微语，登录
			case 1:
			case 2:
			case 3:
				$url = BLOG_URL . $url;
				break;
			//分类
			case 4:
				$url = Url::sort($typeId);
				break;
			//页面
			case 5:
				$url = Url::log($typeId);
				break;
			default:
				$url = (strpos($url, 'http') === 0 ? '' : BLOG_URL) . $url;
				break;
		}
		return $url;
	}

}
