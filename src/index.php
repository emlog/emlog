<?php
/**
 * Front-end main page
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

require_once 'common.php';
viewCount();

define('TEMPLATE_URL', 	TPLS_URL.$nonce_templet.'/');//Front-end template URL
define('TEMPLATE_PATH', TPLS_PATH.$nonce_templet.'/');//Foreground template path

$blogtitle = $blogname;
$logid = isset($_GET['post']) ? intval($_GET['post']) : '';
$plugin = isset($_GET['plugin']) ? addslashes($_GET['plugin']) : '';

//Blog List
if (empty($action) && empty($logid) && empty($plugin)) {
	require_once EMLOG_ROOT.'/model/class.blog.php';

	$emBlog = new emBlog();

	$page = isset($_GET['page']) ? abs(intval($_GET['page'])) : 1;
	$record = isset($_GET['record']) ? intval($_GET['record']) : '' ;
	$tag = isset($_GET['tag']) ? addslashes(strval(trim($_GET['tag']))) : '';
	$sortid = isset($_GET['sort']) ? intval($_GET['sort']) : '';
	$author = isset($_GET['author']) ? intval($_GET['author']) : '';
	$keyword = isset($_GET['keyword']) ? addslashes(trim($_GET['keyword'])) : '';

	$start_limit = ($page - 1) * $index_lognum;
	$pageurl = '';

	if (preg_match("/^[\d]{6,8}$/", $record)) {
		$blogtitle = $record.' - '.$blogname;
		if (preg_match("/^([\d]{4})([\d]{2})$/", $record, $match)) {
		    $days = getMonthDayNum($match[2], $match[1]);
		    $record_stime = emStrtotime($record . '01');
		    $record_etime = $record_stime + 3600 * 24 * $days;
		} else {
		    $record_stime = emStrtotime($record);
		    $record_etime = $record_stime + 3600 * 24;
		}
		$sqlSegment = "and date>=$record_stime and date<$record_etime order by top desc ,date desc";
		$lognum = $emBlog->getLogNum('n', $sqlSegment);
		$pageurl .= BLOG_URL."?record=$record&page";
	} elseif ($tag) {
		require_once EMLOG_ROOT.'/model/class.tag.php';
		$emTag = new emTag();
		$blogtitle = stripslashes($tag).' - '.$blogname;
		$blogIdStr = $emTag->getTagByName($tag);
		if ($blogIdStr === false) {
			emMsg(lang['tag_not_exists'], BLOG_URL);
		}
		$sqlSegment = "and gid IN ($blogIdStr) order by date desc";
		$lognum = $emBlog->getLogNum('n', $sqlSegment);
		$pageurl .= BLOG_URL.'?tag='.urlencode($tag).'&page';
	} elseif ($keyword) {
		$keyword = str_replace('%','\%',$keyword);
		$keyword = str_replace('_','\_',$keyword);
		$sqlSegment = "and title like '%{$keyword}%' order by date desc";
		$lognum = $emBlog->getLogNum('n', $sqlSegment);
		$pageurl .= BLOG_URL.'?keyword='.urlencode($keyword).'&page';
	} elseif (isset($sort_cache[$sortid])) {
		$sortName = $sort_cache[$sortid]['sortname'];
		$blogtitle = $sortName.' - '.$blogname;
		$sqlSegment = "and sortid=$sortid order by date desc";
		$lognum = $emBlog->getLogNum('n', $sqlSegment);
		$pageurl .= BLOG_URL."?sort=$sortid&page";
	} elseif (isset($user_cache[$author])) {
		$blogtitle = $user_cache[$author]['name'].' - '.$blogname;
		$sqlSegment = "and author=$author order by date desc";
		$lognum = $sta_cache[$author]['lognum'];
		$pageurl .= BLOG_URL."?author=$author&page";
	}else {
		$sqlSegment ="ORDER BY top DESC ,date DESC";
		$lognum = $sta_cache['lognum'];
		$pageurl .= BLOG_URL.'?page';
	}
	$logs = $emBlog->getLogsForHome($sqlSegment, $page, $index_lognum);
	$page_url = pagination($lognum, $index_lognum, $page, $pageurl);

	include getViews('header');
	include getViews('log_list');
}

//Blog post list
if (!empty($logid)) {
	require_once EMLOG_ROOT.'/model/class.blog.php';
	require_once EMLOG_ROOT.'/model/class.comment.php';
	require_once EMLOG_ROOT.'/model/class.trackback.php';

	$emBlog = new emBlog();
	$emComment = new emComment();
	$emTrackback = new emTrackback();

	$logData = $emBlog->getOneLogForHome($logid);
	if ($logData === false) {
		emMsg(lang['post_not_exists'], BLOG_URL);
	}
	extract($logData);
	if (!empty($password)) {
		$postpwd = isset($_POST['logpwd']) ? addslashes(trim($_POST['logpwd'])) : '';
		$cookiepwd = isset($_COOKIE['em_logpwd_'.$logid]) ? addslashes(trim($_COOKIE['em_logpwd_'.$logid])) : '';
		$emBlog->AuthPassword($postpwd, $cookiepwd, $password, $logid);
	}
	$blogtitle = $log_title.' - '.$blogname;

	//comments
	$cheackimg = $comment_code == 'y' ? "<img src=\"".BLOG_URL."lib/checkcode.php\" align=\"absmiddle\" /><input name=\"imgcode\"  type=\"text\" class=\"input\" size=\"5\">" : '';
	$ckname = isset($_COOKIE['commentposter']) ? htmlspecialchars(stripslashes($_COOKIE['commentposter'])) : '';
	$ckmail = isset($_COOKIE['postermail']) ? $_COOKIE['postermail'] : '';
	$ckurl = isset($_COOKIE['posterurl']) ? $_COOKIE['posterurl'] : '';
	$comments = $emComment->getComments(0, $logid, 'n');

	$curpage = CURPAGE_LOG;
	include getViews('header');
	if ($type == 'blog') {
		$emBlog->updateViewCount($logid);
		$neighborLog = $emBlog->neighborLog($timestamp);
		extract($neighborLog);
		$tb = $emTrackback->getTrackbacks(null, $logid, 0);
		require_once getViews('echo_log');
	}elseif ($type == 'page') {
		include getViews('page');
	}
}

//Comments
if ($action == 'addcom') {
	global $lang;
	require_once EMLOG_ROOT.'/model/class.comment.php';
	$emComment = new emComment();

	$comname = isset($_POST['comname']) ? addslashes(trim($_POST['comname'])) : '';
	$comment = isset($_POST['comment']) ? addslashes(trim($_POST['comment'])) : '';
	$commail = isset($_POST['commail']) ? addslashes(trim($_POST['commail'])) : '';
	$comurl = isset($_POST['comurl']) ? addslashes(trim($_POST['comurl'])) : '';
	$imgcode = isset($_POST['imgcode']) ? strtoupper(trim($_POST['imgcode'])) : '';
	$gid = isset($_POST['gid']) ? intval($_POST['gid']) : -1;

	doAction('comment_post');
	$ret = $emComment->addComment($comname, $comment, $commail, $comurl, $imgcode, $gid);
	switch($ret) {
		case -1:
		emMsg($lang['comments_disabled'],'javascript:history.back(-1);');break;
		case -2:
		emMsg($lang['comment_allready_exists'],'javascript:history.back(-1);');break;
		case -3:
		emMsg($lang['comment_name_invalid'],'javascript:history.back(-1);');break;
		case -4:
		emMsg($lang['comment_email_invalid'], 'javascript:history.back(-1);');break;
		case -5:
		emMsg($lang['comment_invalid'],'javascript:history.back(-1);');break;
		case -6:
		emMsg($lang['comment_captcha_invalid'],'javascript:history.back(-1);');break;
		case 0:
		$CACHE->updateCache(array('sta', 'comment'));
		doAction('comment_saved');
		emMsg($lang['comment_posted_ok'], BLOG_URL."?post=$gid#comment", true);break;
		case 1:
		$CACHE->updateCache('sta');
		doAction('comment_saved');
		emMsg($lang['comment_posted_premod'], BLOG_URL."?post=$gid");break;
	}
}

//Load plug-ins
if (preg_match("/^[\w\-]+$/", $plugin) && file_exists(EMLOG_ROOT."/content/plugins/{$plugin}/{$plugin}_show.php")) {
	include_once("./content/plugins/{$plugin}/{$plugin}_show.php");
}

cleanPage(true);
