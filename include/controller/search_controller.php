<?php

/**
 * search
 *
 * @package EMLOG
 * 
 */

class Search_Controller
{
    /**
     * 搜索页面展示
     *
     * @param mixed $params
     * @return void
     */
    function display($params)
    {
        $Log_Model = new Log_Model();
        $options_cache = Option::getAll();
        extract($options_cache);

        $page = abs(Input::getIntVar('page', 1));
        $keyword = Input::getStrVar('keyword');
        $keyword_clean = stripslashes($keyword);
        $keyword_sql = Database::getInstance()->escape_string($keyword_clean);
        $keyword_sql = str_replace(array('%', '_'), array('\%', '\_'), $keyword_sql);
        $sid = abs(Input::getIntVar('sid'));
        $pageurl = '';

        $sqlSegment = "AND title LIKE '%$keyword_sql%'";
        if ($isfullsearch === 'y') {
            $sqlSegment = "AND (title LIKE '%$keyword_sql%' OR excerpt LIKE '%$keyword_sql%' OR content LIKE '%$keyword_sql%')";
        }
        if ($sid) {
            $sqlSegment .= " AND sortid=$sid";
        }
        doAction('search_log_list', $keyword_clean);
        $orderBy = ' ORDER BY date DESC';
        $lognum = $Log_Model->getLogNum('n', $sqlSegment);
        $total_pages = ceil($lognum / $index_lognum);
        if ($page > $total_pages) {
            $page = $total_pages;
        }

        $pageurl .= BLOG_URL . '?keyword=' . urlencode($keyword_clean) . '&page=';

        $logs = $Log_Model->getLogsForHome($sqlSegment . $orderBy, $page, $index_lognum);
        $page_url = pagination($lognum, $index_lognum, $page, $pageurl);

        $keyword = htmlspecialchars($keyword_clean);
        include View::getView('header');
        include View::getView('log_list');
    }
}
