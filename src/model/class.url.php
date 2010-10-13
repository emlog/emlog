<?php
/**
 * URL处理
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

class Url {

    /**
     * 获取日志链接
     */
    static function log($blogId){
        $logUrl = '';
        switch (Option::get('isurlrewrite')) {
            case '0':
                $logUrl = BLOG_URL . '?post=' . $blogId;
                break;
            case '1':
                $logUrl = BLOG_URL . 'post-' . $blogId . '.html';
                break;
            case '2':
                $logUrl = BLOG_URL . 'post/' . $blogId;
                break;
        }
        return $logUrl;
    }

    /**
     * 获取归档链接
     */
	static function record($record, $page=null){
        $recordUrl = '';
        switch (Option::get('isurlrewrite')) {
            case '0':
                $recordUrl = BLOG_URL . '?record=' . $record;
                if ($page) $recordUrl .= '&page';
                break;
            case '1':
                $recordUrl = BLOG_URL . 'record-' . $record . '.html';
                if ($page) $recordUrl = BLOG_URL . 'record/' . $record . '/page';
                break;
            case '2':
                $recordUrl = BLOG_URL . 'record/' . $record;
                if ($page) $recordUrl = BLOG_URL . 'record/' . $record . '/page';
                break;
        }
        return $recordUrl;
	}

    /**
     * 获取分类链接
     */	
    static function sort($sortId, $page=null){
         $sortUrl = '';
        switch (Option::get('isurlrewrite')) {
            case '0':
                $sortUrl = BLOG_URL . '?sort=' . $sortId;
                if ($page) $sortUrl .= '&page';
                break;
            case '1':
                $sortUrl = BLOG_URL . 'sort-' . $sortId . '.html';
                if ($page) $sortUrl = BLOG_URL . 'sort/' . $sortId . '/page';
                break;
            case '2':
                $sortUrl = BLOG_URL . 'sort/' . $sortId;
                if ($page) $sortUrl = BLOG_URL . 'sort/' . $sortId . '/page';
                break;
        }
        return $sortUrl;
    }

    /**
     * 获取作者链接
     */
    static function author($authorId, $page=null){
        $authorUrl = '';
        switch (Option::get('isurlrewrite')) {
            case '0':
                $authorUrl = BLOG_URL . '?author=' . $authorId;
                if ($page) $authorUrl .= '&page';
                break;
            case '1':
                $authorUrl = BLOG_URL . 'author-' . $authorId . '.html';
                if ($page) $authorUrl = BLOG_URL . 'author/' . $authorId . '/page';
                break;
            case '2':
                $authorUrl = BLOG_URL . 'author/' . $authorId;
                if ($page) $authorUrl = BLOG_URL . 'author/' . $authorId . '/page';
                break;
        }
        return $authorUrl;
    }

    /**
     * 获取标签链接
     */
    static function tag($tag, $page=null){
        $tagUrl = '';
        switch (Option::get('isurlrewrite')) {
            case '0':
                $tagUrl = BLOG_URL . '?tag=' . $tag;
                if ($page) $tagUrl .= '&page';
                break;
            case '1':
                $tagUrl = BLOG_URL . 'tag-' . $tag . '.html';
                if ($page) $tagUrl = BLOG_URL . 'tag/' . $tag . '/page';
                break;
            case '2':
                $tagUrl = BLOG_URL . 'tag/' . $tag;
                if ($page) $tagUrl = BLOG_URL . 'tag/' . $tag . '/page';
                break;
        }
        return $tagUrl;
    }

    /**
     * 获取首页日志分页链接
     */
    static function logPage(){
        $logPageUrl = '';
        switch (Option::get('isurlrewrite')) {
            case '0':
                $logPageUrl = BLOG_URL . '?page';
                break;
            case '1':
            case '2':
                $logPageUrl = BLOG_URL . 'page';
                break;
        }
        return $logPageUrl;
    }

    /**
     * 获取分页链接
     */
    static function page($url, $pageId){
        $pageUrl = '';
        if (preg_match("/^.*[?&]page$/", $url)) {
        	$pageUrl = $url . '=' . $pageId;
        } else {
        	$pageUrl = $url . '/' . $pageId . '/';
        }
        return $pageUrl;
    }
}
