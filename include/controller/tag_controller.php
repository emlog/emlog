<?php
/**
 * tags
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Tag_Controller {
    function display($params) {
        $Log_Model = new Log_Model();
        $options_cache = Option::getAll();
        extract($options_cache);

        $page = isset($params[4]) && $params[4] == 'page' ? abs((int)$params[5]) : 1;
        $tag = isset($params[1]) && $params[1] == 'tag' ? addslashes(urldecode(trim($params[2]))) : '';

        //page meta
        $site_title = stripslashes($tag) . ' - ' . $site_title;

        $Tag_Model = new Tag_Model();
        $blogIdStr = $Tag_Model->getTagByName($tag);
        $lognum = 0;
        $total_pages = 0;
        $logs = [];
        if ($blogIdStr) {
            $sqlSegment = "and gid IN ($blogIdStr) order by date desc";
            $logs = $Log_Model->getLogsForHome($sqlSegment, $page, $index_lognum);
            $lognum = $Log_Model->getLogNum('n', $sqlSegment);
            $total_pages = ceil($lognum / $index_lognum);
        }

        if ($page > $total_pages) {
            $page = $total_pages;
        }

        $page_url = pagination($lognum, $index_lognum, $page, Url::tag(urlencode($tag), 'page'));

        include View::getView('header');
        include View::getView('log_list');
    }
}
