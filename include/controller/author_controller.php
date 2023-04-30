<?php
/**
 * author's articles
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Author_Controller {
    function display($params) {
        $Log_Model = new Log_Model();
        $User_Model = new User_Model();

        $CACHE = Cache::getInstance();
        $options_cache = Option::getAll();
        extract($options_cache);

        $page = isset($params[4]) && $params[4] == 'page' ? abs((int)$params[5]) : 1;
        $author = isset($params[1]) && $params[1] == 'author' ? (int)$params[2] : '';

        $user_info = $User_Model->getOneUser($author);
        if (empty($user_info)) {
            show_404_page();
        }
        $author_name = $user_info['nickname'];

        //page meta
        $site_title = $author_name . ' - ' . $site_title;

        $sqlSegment = "and author=$author order by date desc";
        $sta_cache = $CACHE->readCache('sta');
        $lognum = $sta_cache[$author]['lognum'];

        $total_pages = ceil($lognum / $index_lognum);
        if ($page > $total_pages) {
            $page = $total_pages;
        }
        $start_limit = ($page - 1) * $index_lognum;

        $Log_Model = new Log_Model();
        $logs = $Log_Model->getLogsForHome($sqlSegment, $page, $index_lognum);
        $page_url = pagination($lognum, $index_lognum, $page, Url::author($author, 'page'));

        include View::getView('header');
        include View::getView('log_list');
    }
}
