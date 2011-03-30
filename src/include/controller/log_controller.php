<?php
/**
 * 显示博客首页、博客内容
 *
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

class Log_Controller {

    /**
     * 前台日志列表页面输出
     */
    function display($params) {
        $Log_Model = new Log_Model();
        $CACHE = Cache::getInstance();
        $options_cache = $CACHE->readCache('options');
        extract($options_cache);
        $navibar = unserialize($navibar);
        $curpage = CURPAGE_HOME;
        
        //page meta
        $blogtitle = $blogname;
        $description = $bloginfo;

        $page = isset($params[1]) && $params[1] == 'page' ? abs(intval($params[2])) : 1;

        $start_limit = ($page - 1) * $index_lognum;
        $pageurl = '';

        $sqlSegment ='ORDER BY top DESC ,date DESC';
        $sta_cache = $CACHE->readCache('sta');
        $lognum = $sta_cache['lognum'];
        $pageurl .= Url::logPage();
        $logs = $Log_Model->getLogsForHome($sqlSegment, $page, $index_lognum);
        $page_url = pagination($lognum, $index_lognum, $page, $pageurl);

        include View::getView('header');
        include View::getView('log_list');
    }

    /**
     * 前台日志内容页面输出
     */
    function displayContent($params) {
    	$Log_Model = new Log_Model();
        $CACHE = Cache::getInstance();
        $options_cache = $CACHE->readCache('options');
        extract($options_cache);
        $navibar = unserialize($navibar);

        $logid = '' ;

        if (isset($params[1])) {
        	if ($params[1] == 'post') {
        		$logid = isset($params[2]) ? intval($params[2]) : '';
        	} elseif (is_numeric($params[1])) {
        		$logid = intval($params[1]);
        	} else {
        		$logalias_cache = $CACHE->readCache('logalias');
	        	if (!empty($logalias_cache)) {
	        		$alias = addslashes(urldecode(trim($params[1])));
	        		$logid = array_search($alias, $logalias_cache);
	        		if (!$logid) {
	        			emMsg('不存在该条目', BLOG_URL);
	        		}
	        	}
        	}
        }

        $Comment_Model = new Comment_Model();
        $Trackback_Model = new Trackback_Model();

        $logData = $Log_Model->getOneLogForHome($logid);
        if ($logData === false) {
            emMsg('不存在该条目', BLOG_URL);
        }
        extract($logData);

        if (!empty($password)) {
            $postpwd = isset($_POST['logpwd']) ? addslashes(trim($_POST['logpwd'])) : '';
            $cookiepwd = isset($_COOKIE['em_logpwd_'.$logid]) ? addslashes(trim($_COOKIE['em_logpwd_'.$logid])) : '';
            $Log_Model->AuthPassword($postpwd, $cookiepwd, $password, $logid);
        }
        //page meta
        $blogtitle = $log_title.' - '.$blogname;
        $description = subString(str_replace(array("\r\n","\n"), ' ', strip_tags($log_content)), 0, 300);
        $log_cache_tags = $CACHE->readCache('logtags');
        if (!empty($log_cache_tags[$logid])){
	        foreach ($log_cache_tags[$logid] as $value){
	            $site_key .= ','.$value['tagname'];
	        }
        }
        //comments
        $verifyCode = $comment_code == 'y' ? "<img src=\"".BLOG_URL."include/lib/checkcode.php\" align=\"absmiddle\" /><input name=\"imgcode\" type=\"text\" class=\"input\" size=\"5\" />" : '';
        $ckname = isset($_COOKIE['commentposter']) ? htmlspecialchars(stripslashes($_COOKIE['commentposter'])) : '';
        $ckmail = isset($_COOKIE['postermail']) ? $_COOKIE['postermail'] : '';
        $ckurl = isset($_COOKIE['posterurl']) ? $_COOKIE['posterurl'] : '';
        $comments = $Comment_Model->getComments(0, $logid, 'n');

        $curpage = CURPAGE_LOG;
        include View::getView('header');
        if ($type == 'blog') {
            $Log_Model->updateViewCount($logid);
            $neighborLog = $Log_Model->neighborLog($timestamp);
            $tb = $Trackback_Model->getTrackbacks(null, $logid, 0);
            $tb_url = BLOG_URL . 'tb.php?sc=' . $tbscode . '&id=' . $logid; 
            require_once View::getView('echo_log');
        }elseif ($type == 'page') {
            include View::getView('page');
        }
    }
}
