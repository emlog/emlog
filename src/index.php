<?php
/**
 * 前端页面加载
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.4.0
 * $Id$
 */

require_once 'common.php';
viewCount();

define('TEMPLATE_URL', 	TPLS_URL.$nonce_templet.'/');//前台模板URL
define('TEMPLATE_PATH', TPLS_PATH.$nonce_templet.'/');//前台模板路径

$blogtitle = $blogname;
$calendar_url = isset($_GET['record']) ? DYNAMIC_BLOGURL.'calendar.php?record='.intval($_GET['record']) : DYNAMIC_BLOGURL.'calendar.php?' ;
$logid = isset($_GET['post']) ? intval($_GET['post']) : '';
$plugin = isset($_GET['plugin']) ? addslashes($_GET['plugin']) : '';

//日志列表
if (empty($action) && empty($logid) && empty($plugin))
{
	require_once EMLOG_ROOT.'/model/class.blog.php';

	$emBlog = new emBlog($DB);

	$page = isset($_GET['page']) ? abs(intval($_GET['page'])) : 1;
	$record = isset($_GET['record']) ? intval($_GET['record']) : '' ;
	$tag = isset($_GET['tag']) ? addslashes(strval(trim($_GET['tag']))) : '';
	$sortid = isset($_GET['sort']) ? intval($_GET['sort']) : '';
	$author = isset($_GET['author']) ? intval($_GET['author']) : '';
	$keyword = isset($_GET['keyword']) ? addslashes(trim($_GET['keyword'])) : '';

	$start_limit = ($page - 1) * $index_lognum;
	$pageurl = '';

	if ($record)
	{
		$blogtitle = $record.' - '.$blogname;
		$sqlSegment = "and from_unixtime(date, '%Y%m%d') LIKE '%".$record."%' order by top desc ,date desc";
		$lognum = $emBlog->getLogNum('n', $sqlSegment);
		$pageurl .= BLOG_URL."?record=$record&page";
	} elseif ($tag) {
		require_once EMLOG_ROOT.'/model/class.tag.php';
		$emTag = new emTag($DB);
		$blogtitle = stripslashes($tag).' - '.$blogname;
		$blogIdStr = $emTag->getTagByName($tag);
		if($blogIdStr === false)
		{
			emMsg('不存在该标签','./');
		}
		$sqlSegment = "and gid IN ($blogIdStr) order by date desc";
		$lognum = $emBlog->getLogNum('n', $sqlSegment);
		$pageurl .= BLOG_URL.'?tag='.urlencode($tag).'&page';
	} elseif($keyword) {
		$keyword = str_replace('%','\%',$keyword);
		$keyword = str_replace('_','\_',$keyword);
		$sqlSegment = "and title like '%{$keyword}%' order by date desc";
		$lognum = $emBlog->getLogNum('n', $sqlSegment);
		$pageurl .= BLOG_URL.'?keyword='.urlencode($keyword).'&page';
	} elseif(isset($sort_cache[$sortid])) {
		$sortName = $sort_cache[$sortid]['sortname'];
		$blogtitle = $sortName.' - '.$blogname;
		$sqlSegment = "and sortid=$sortid order by date desc";
		$lognum = $emBlog->getLogNum('n', $sqlSegment);
		$pageurl .= BLOG_URL."?sort=$sortid&page";
	} elseif(isset($user_cache[$author])) {
		$blogtitle = $user_cache[$author]['name'].' - '.$blogname;
		$sqlSegment = "and author=$author order by date desc";
		$lognum = $user_cache[$author]['lognum'];
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
//浏览日志、页面
if (!empty($logid))
{
	require_once EMLOG_ROOT.'/model/class.blog.php';
	require_once EMLOG_ROOT.'/model/class.comment.php';
	require_once EMLOG_ROOT.'/model/class.trackback.php';

	$emBlog = new emBlog($DB);
	$emComment = new emComment($DB);
	$emTrackback = new emTrackback($DB);

	$logData = $emBlog->getOneLogForHome($logid);
	if($logData === false)
	{
		emMsg('不存在该条目','./');
	}
	extract($logData);
	if(!empty($password))
	{
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
	include getViews('header');
	if ($type == 'blog')
	{
		$emBlog->updateViewCount($logid);
		$neighborLog = $emBlog->neighborLog($date);
		extract($neighborLog);
		$tb = $emTrackback->getTrackbacks(null, $logid, 0);
		require_once getViews('echo_log');
	}elseif ($type == 'page'){
		include getViews('page');
	}
}
//发表评论
if ($action == 'addcom')
{
	require_once EMLOG_ROOT.'/model/class.comment.php';
	$emComment = new emComment($DB);

	$comname = isset($_POST['comname']) ? addslashes(trim($_POST['comname'])) : '';
	$comment = isset($_POST['comment']) ? addslashes(trim($_POST['comment'])) : '';
	$commail = isset($_POST['commail']) ? addslashes(trim($_POST['commail'])) : '';
	$comurl = isset($_POST['comurl']) ? addslashes(trim($_POST['comurl'])) : '';
	$imgcode = strtoupper(trim(isset($_POST['imgcode']) ? $_POST['imgcode'] : ''));
	$gid = isset($_POST['gid']) ? intval($_POST['gid']) : -1;

	doAction('comment_post');
	$ret = $emComment->addComment($comname, $comment, $commail, $comurl, $imgcode, $gid);
	switch($ret){
		case -1:
		emMsg('发表评论失败：该日志已关闭评论','javascript:history.back(-1);');break;
		case -2:
		emMsg('发表评论失败：已存在相同内容评论','javascript:history.back(-1);');break;
		case -3:
		emMsg('发表评论失败：姓名不符合规范','javascript:history.back(-1);');break;
		case -4:
		emMsg('发表评论失败：邮件地址不符合规范', 'javascript:history.back(-1);');break;
		case -5:
		emMsg('发表评论失败：内容不符合规范','javascript:history.back(-1);');break;
		case -6:
		emMsg('发表评论失败：验证码错误','javascript:history.back(-1);');break;
		case 0:
		$CACHE->mc_sta();
		$CACHE->mc_user();
		$CACHE->mc_comment();
		doAction('comment_saved');
		emMsg('评论发表成功', BLOG_URL."?post=$gid#comment", true);break;
		case 1:
		$CACHE->mc_sta();
		$CACHE->mc_user();
		doAction('comment_saved');
		emMsg('评论发表成功，请等待管理员审核', BLOG_URL."?post=$gid");break;
	}
}
//加载插件页面
if (preg_match("/^[\w\-]+$/", $plugin) && file_exists(EMLOG_ROOT."/content/plugins/{$plugin}/{$plugin}_show.php"))
{
	include_once("./content/plugins/{$plugin}/{$plugin}_show.php");
}

cleanPage(true);
