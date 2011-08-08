<?php
/**
 * URL处理
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

class Url
{
    /**
     * 获取日志链接
     */
    static function log ($blogId)
    {
    	$urlMode = Option::get('isurlrewrite');
        $logUrl = '';
        $CACHE = Cache::getInstance();

        //开启日志别名
        if (Option::get('isalias') == 'y') {
            $CACHE = Cache::getInstance();
            $logalias_cache = $CACHE->readCache('logalias');
            if (!empty($logalias_cache[$blogId])) {
            	$logsort_cache = $CACHE->readCache('logsort');
            	$sort = '';
            	//分类模式下的url
            	if (3 == $urlMode && isset($logsort_cache[$blogId])) {
            		$sort = !empty($logsort_cache[$blogId]['alias']) ? 
            			$logsort_cache[$blogId]['alias'] : 
            			$logsort_cache[$blogId]['name'];
            		$sort .= '/';
            	}
                $logUrl = BLOG_URL . $sort . urlencode($logalias_cache[$blogId]);
                //开启别名html后缀
                if (Option::get('isalias_html') == 'y') {
                	$logUrl .= '.html';
                }
                return $logUrl;
            }
        }

        switch ($urlMode) {
            case '0'://默认：动态
                $logUrl = BLOG_URL . '?post=' . $blogId;
                break;
            case '1'://静态
                $logUrl = BLOG_URL . 'post-' . $blogId . '.html';
                break;
            case '2'://目录
                $logUrl = BLOG_URL . 'post/' . $blogId;
                break;
            case '3'://分类
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
     * 获取归档链接
     */
    static function record ($record, $page = null)
    {
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
     * 获取分类链接
     */
    static function sort ($sortId, $page = null)
    {
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
     * 获取作者链接
     */
    static function author ($authorId, $page = null)
    {
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
     * 获取标签链接
     */
    static function tag ($tag, $page = null)
    {
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
     * 获取首页日志分页链接
     */
    static function logPage ()
    {
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
     * 获取分页链接
     */
    static function page ($url, $pageId)
    {
        return $url . $pageId;
    }
}
