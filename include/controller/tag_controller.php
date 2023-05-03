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

        $pageurl = '';

        //page meta
        $site_title = stripslashes($tag) . ' - ' . $site_title;

        $Tag_Model = new Tag_Model();

        if (!$Tag_Model->getIdFromName($tag)) {
            show_404_page();
        }

        $lognum = 0;
        $logs = [];
        $blogIdStr = $Tag_Model->getTagByName($tag);
        if ($blogIdStr) {
            $sqlSegment = "and gid IN ($blogIdStr) order by date desc";
            $lognum = $Log_Model->getLogNum('n', $sqlSegment);
            $logs = $Log_Model->getLogsForHome($sqlSegment, $page, $index_lognum);
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
