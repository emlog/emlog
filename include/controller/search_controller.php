<?php
/**
 * search
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Search_Controller {
    function display($params) {
        $Log_Model = new Log_Model();
        $options_cache = Option::getAll();
        extract($options_cache);

        $page = isset($params[4]) && $params[4] == 'page' ? abs((int)$params[5]) : 1;
        $keyword = isset($params[1]) && $params[1] == 'keyword' ? trim($params[2]) : '';
        $keyword = addslashes(htmlspecialchars(urldecode($keyword)));
        $keyword = str_replace(array('%', '_'), array('\%', '\_'), $keyword);

        $sqlSegment = "and title like '%{$keyword}%' order by date desc";
        $lognum = $Log_Model->getLogNum('n', $sqlSegment);
        $total_pages = ceil($lognum / $index_lognum);
        if ($page > $total_pages) {
            $page = $total_pages;
        }

        $url = BLOG_URL . '?keyword=' . urlencode($keyword) . '&page=';
        $logs = $Log_Model->getLogsForHome($sqlSegment, $page, $index_lognum);
        $page_url = pagination($lognum, $index_lognum, $page, $url);

        include View::getView('header');
        include View::getView('log_list');
    }
}
