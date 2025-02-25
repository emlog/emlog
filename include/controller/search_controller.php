<?php

/**
 * search
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Search_Controller
{
    function display($params)
    {
        $Log_Model = new Log_Model();
        $options_cache = Option::getAll();
        extract($options_cache);

        $page = abs(Input::getIntVar('page', 1));
        $keyword = Input::getStrVar('keyword');
        $keyword = htmlspecialchars(urldecode($keyword));
        $keyword = str_replace(array('%', '_'), array('\%', '\_'), $keyword);
        $sid = abs(Input::getIntVar('sid'));
        $pageurl = '';

        $sqlSegment = "AND title LIKE '%$keyword%'";
        if ($isfullsearch === 'y') {
            $sqlSegment = "AND (title LIKE '%$keyword%' OR excerpt LIKE '%$keyword%' OR content LIKE '%$keyword%')";
        }
        if ($sid) {
            $sqlSegment .= " AND sortid=$sid";
        }
        $orderBy = ' ORDER BY date DESC';
        $lognum = $Log_Model->getLogNum('n', $sqlSegment);
        $total_pages = ceil($lognum / $index_lognum);
        if ($page > $total_pages) {
            $page = $total_pages;
        }

        $pageurl .= BLOG_URL . '?keyword=' . urlencode($keyword) . '&page=';

        $logs = $Log_Model->getLogsForHome($sqlSegment . $orderBy, $page, $index_lognum);
        $page_url = pagination($lognum, $index_lognum, $page, $pageurl);

        include View::getView('header');
        include View::getView('log_list');
    }
}
