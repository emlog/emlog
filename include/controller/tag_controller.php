<?php

/**
 * tags
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Tag_Controller
{
    function display($params)
    {
        $Log_Model = new Log_Model();
        $options_cache = Option::getAll();
        extract($options_cache);

        $page = isset($params[4]) && $params[4] == 'page' ? abs((int)$params[5]) : 1;
        $tag = isset($params[1]) && $params[1] == 'tag' ? addslashes(urldecode(trim($params[2]))) : '';

        $pageurl = '';
        $lognum = 0;
        $logs = [];
        $Tag_Model = new Tag_Model();
        $tag_detail = $Tag_Model->getDetailByName($tag);
        if (empty($tag_detail)) {
            show_404_page();
        }
        $blogIdStr = $Tag_Model->getTagById($tag_detail['tid']);
        if ($blogIdStr) {
            $sqlSegment = "and gid IN ($blogIdStr)";
            $orderBy = 'order by date desc';
            $lognum = $Log_Model->getLogNum('n', $sqlSegment);
            $logs = $Log_Model->getLogsForHome($sqlSegment . $orderBy, $page, $index_lognum);
        }

        $tagTitle = isset($tag_detail['title']) ? $tag_detail['title'] : '';
        $tagKw = isset($tag_detail['kw']) ? $tag_detail['kw'] : '';
        $tagDesc = isset($tag_detail['description']) ? $tag_detail['description'] : '';

        //page meta
        if ($tagTitle) {
            $site_title = $tagTitle;
        } else {
            $site_title = stripslashes($tag) . ' - ' . $site_title;
        }
        if ($tagDesc) {
            $site_description = $tagDesc;
        }
        if ($tagKw) {
            $site_key = $tagKw;
        }

        $total_pages = ceil($lognum / $index_lognum);
        if ($page > $total_pages) {
            $page = $total_pages;
        }
        $pageurl .= Url::tag(urlencode($tag), 'page');
        $page_url = pagination($lognum, $index_lognum, $page, $pageurl);

        include View::getView('header');
        include View::getView('log_list');
    }
}
