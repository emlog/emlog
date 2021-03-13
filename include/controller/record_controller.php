<?php
/**
 * View Archive
 *
 * @package EMLOG
 */

class Record_Controller
{
    function display($params)
    {
        $Log_Model = new Log_Model();
        $options_cache = Option::getAll();
        extract($options_cache);

        $page = isset($params[4]) && $params[4] == 'page' ? abs((int)$params[5]) : 1;
        $record = isset($params[1]) && $params[1] == 'record' ? (int)$params[2] : '';

        $GLOBALS['record'] = $record;//for sidebar calendar

        $pageurl = '';

        //page meta
        $site_title = $record . ' - ' . $site_title;

        if (preg_match("/^([\d]{4})([\d]{2})$/", $record, $match)) {
            $days = getMonthDayNum($match[2], $match[1]);
            $record_stime = strtotime($record . '01');
            $record_etime = $record_stime + 3600 * 24 * $days;
        } else {
            $record_stime = strtotime($record);
            $record_etime = $record_stime + 3600 * 24;
        }
        $sqlSegment = "and date>=$record_stime and date<$record_etime order by date desc";
        $lognum = $Log_Model->getLogNum('n', $sqlSegment);

        $total_pages = ceil($lognum / $index_lognum);
        if ($page > $total_pages) {
            $page = $total_pages;
        }
        $start_limit = ($page - 1) * $index_lognum;

        $pageurl .= Url::record($record, 'page');

        $logs = $Log_Model->getLogsForHome($sqlSegment, $page, $index_lognum);
        $page_url = pagination($lognum, $index_lognum, $page, $pageurl);

        include View::getView('header');
        include View::getView('log_list');
    }
}
