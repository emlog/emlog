<?php
/**
 * 显示博客首页、博客内容
 *
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

class LogController {

    /**
     * 前台日志列表页面输出
     */
    function display($params) {
        $emBlog = new emBlog();
        $CACHE = Cache::getInstance();
        $options_cache = $CACHE->readCache('options');
        extract($options_cache);
        $navibar = unserialize($navibar);
        $curpage = CURPAGE_HOME;
        $blogtitle = $blogname;

        $page = isset($params[1]) && $params[1] == 'page' ? abs(intval($params[2])) : 1;

        $start_limit = ($page - 1) * $index_lognum;
        $pageurl = '';

        $sqlSegment ='ORDER BY top DESC ,date DESC';
        $sta_cache = $CACHE->readCache('sta');
        $lognum = $sta_cache['lognum'];
        $pageurl .= Url::logPage();
        $logs = $emBlog->getLogsForHome($sqlSegment, $page, $index_lognum);
        $page_url = pagination($lognum, $index_lognum, $page, $pageurl);

        include View::getView('header');
        include View::getView('log_list');
    }

    /**
     * 前台日志内容页面输出
     */
    function displayContent($params) {
    	$emBlog = new emBlog();
        $CACHE = Cache::getInstance();
        $options_cache = $CACHE->readCache('options');
        extract($options_cache);
        $navibar = unserialize($navibar);

        $logid = isset($params[1]) && $params[1] == 'post' ? intval($params[2]) : '' ;

        $emComment = new emComment();
        $emTrackback = new emTrackback();

        $logData = $emBlog->getOneLogForHome($logid);
        if ($logData === false) {
            emMsg('不存在该条目', BLOG_URL);
        }
        extract($logData);
  
        if (!empty($password)) {
            $postpwd = isset($_POST['logpwd']) ? addslashes(trim($_POST['logpwd'])) : '';
            $cookiepwd = isset($_COOKIE['em_logpwd_'.$logid]) ? addslashes(trim($_COOKIE['em_logpwd_'.$logid])) : '';
            $emBlog->AuthPassword($postpwd, $cookiepwd, $password, $logid);
        }
        $blogtitle = $log_title.' - '.$blogname;
        //comments
        $verifyCode = $comment_code == 'y' ? "<img src=\"".BLOG_URL."include/lib/checkcode.php\" align=\"absmiddle\" /><input name=\"imgcode\"  type=\"text\" class=\"input\" size=\"5\">" : '';
        $ckname = isset($_COOKIE['commentposter']) ? htmlspecialchars(stripslashes($_COOKIE['commentposter'])) : '';
        $ckmail = isset($_COOKIE['postermail']) ? $_COOKIE['postermail'] : '';
        $ckurl = isset($_COOKIE['posterurl']) ? $_COOKIE['posterurl'] : '';
        $comments = $emComment->getComments(0, $logid, 'n');

        $curpage = CURPAGE_LOG;
        include View::getView('header');
        if ($type == 'blog') {
            $emBlog->updateViewCount($logid);
            $neighborLog = $emBlog->neighborLog($timestamp);
            $tb = $emTrackback->getTrackbacks(null, $logid, 0);
            $tb_url = BLOG_URL . 'tb.php?sc=' . $tbscode . '&id=' . $logid; 
            require_once View::getView('echo_log');
        }elseif ($type == 'page') {
            include View::getView('page');
        }
    }
}
