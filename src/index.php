<?php
/**
 * 前端页面加载主程序
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.7.0
 * $Id$
 */

require_once('./common.php');
require_once('./model/C_blog.php');
require_once('./model/C_comment.php');
require_once('./model/C_trackback.php');

define('CURPAGE','index');

viewCount();

//check template
$em_tpldir = $tpl_dir.$nonce_templet.'/';//当前模板目录
if (!is_dir($em_tpldir))
{
	exit('Template Error: no template directory!');
}
//calendar url
$calendar_url = isset($_GET['record']) ? 'calendar.php?record='.intval($_GET['record']) : 'calendar.php?' ;
$job = array('showlog','search','addcom','taglog','');
if (!in_array($action,$job))
{
	msg('error!','./index.php');
}
$blogtitle = $blogname;

//日志列表
if (!isset($action) || empty($action))
{
	//page link
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$start_limit = ($page - 1) * $index_lognum;
	$pageurl= './index.php';

	//查询归档或日历对应日志
	$record = isset($_GET['record']) ? intval($_GET['record']) : '' ;
	//查询标签对应日志
	$tag = isset($_GET['tag']) ? addslashes(strval(trim($_GET['tag']))) : '';
	//搜索日志
	$keyword = isset($_GET['keyword']) ? addslashes(trim($_GET['keyword'])) : '';

	$sql = '';
	if ($record)
	{
		$add_query = "AND from_unixtime(date, '%Y%m%d') LIKE '%".$record."%'";
		$sql = "SELECT * FROM ".DB_PREFIX."blog WHERE hide='n'  $add_query ORDER BY top DESC ,date DESC LIMIT $start_limit, $index_lognum";
		$query = $DB->query("SELECT gid FROM ".DB_PREFIX."blog WHERE hide='n'  $add_query ");
		$lognum = $DB->num_rows($query);
		$pageurl .= "?record=$record&page";
	} elseif ($tag) {
		$tagstring = @$DB->fetch_one_array("SELECT tagname,gid FROM ".DB_PREFIX."tag WHERE tagname='$tag' ") OR msg('不存在该标签','javascript:history.back(-1);');
		$gids  = substr(trim($tagstring['gid']),1,-1);
		$tag   = $tagstring['tagname'];
		$sql = "SELECT * FROM ".DB_PREFIX."blog WHERE gid IN ($gids) AND hide='n'";
		$query = $DB->query($sql);
		$lognum = $DB->num_rows($query);
		$sql .= " ORDER BY date DESC LIMIT $start_limit, $index_lognum";
		$pageurl .= "?tag=$tag&page";
	} elseif($keyword) {
		//参数过滤
		$keyword = str_replace('%','\%',$keyword);
		$keyword = str_replace('_','\_',$keyword);
		if (strlen($keyword) > 30 || strlen($keyword) < 3)
		{
			msg('错误的关键字长度','./index.php');
		}
		$sql = "SELECT * FROM ".DB_PREFIX."blog WHERE title like '%{$keyword}%' AND hide='n'";
		$query = $DB->query($sql);
		$lognum = $DB->num_rows($query);
		$sql .= " ORDER BY date DESC LIMIT $start_limit, $index_lognum";
		$pageurl .= "?keyword=$keyword&page";
	} else {
		$sql =" SELECT * FROM ".DB_PREFIX."blog WHERE hide='n' ORDER BY top DESC ,date DESC  LIMIT $start_limit, $index_lognum";
		$lognum = $sta_cache['lognum'];
		$pageurl .= "?page";
	}
	$logs = array();
	$query = $DB->query($sql);
	while ($row = $DB->fetch_array($query))
	{
		$row['post_time'] = date('Y-n-j G:i l',$row['date']);
		$row['log_title'] = htmlspecialchars(trim($row['title']));
		$row['logid']	  = $row['gid'];
		$row['log_description'] = breakLog($row['content'],$row['gid']);
		//attachment
		$row['attachment'] = !empty($log_cache_atts[$row['gid']]['attachment']) ? '<b>文件附件：</b>'.$log_cache_atts[$row['gid']]['attachment'] : '';
		$row['att_img'] = !empty($log_cache_atts[$row['gid']]['att_img']) ? $log_cache_atts[$row['gid']]['att_img'] : '';
		//tag
		$row['tag']  = !empty($log_cache_tags[$row['gid']]) ? '标签:'.$log_cache_tags[$row['gid']] : '';
		//e-mail
		$row['name'] = $user_cache['mail'] != '' ? "<a href=\"mailto:".$user_cache['mail']."\">".$user_cache['name']."</a>" : $user_cache['name'];
		//top
		$row['toplog'] = $row['top'];

		$logs[] = $row;
	}
	//分页
	$page_url = pagination($lognum, $index_lognum, $page, $pageurl);

	include getViews('header');
	include getViews('log_list');
}

//显示日志
if ($action == 'showlog')
{
	isset($_GET['gid']) ? $logid = intval($_GET['gid']) : msg('提交参数错误','./index.php');
	
	$emBlog = new emBlog($DB);
	$emComment = new emComment($DB);
	$emTrackback = new emTrackback($DB);

	$logData = $emBlog->getOneLog($logid, 'n');
	if($logData === false)
	{
		msg('不存在该日志','./index.php');
	}
	extract($logData);
	$log_author = $user_cache['name'];
	$blogurl    = $blogurl;
	//add viewcount
	$emBlog->updateViewCount($logid);
	//neighborlog
	$neighborLog = $emBlog->neighborLog($logid);
	extract($neighborLog);
	//tags
	$tag = !empty($log_cache_tags[$logid]) ? '标签:'.$log_cache_tags[$logid] : '';
	//attachment
	$attachment = !empty($log_cache_atts[$logid]) ? '<b>文件附件</b>:'.$log_cache_atts[$logid] : '';
	//comments
	$cheackimg = $comment_code == 'y' ? "<img src=\"./lib/C_checkcode.php\" align=\"absmiddle\" /><input name=\"imgcode\"  type=\"text\" class=\"input\" size=\"5\">" : '';
	$ckname = isset($_COOKIE['commentposter']) ? htmlspecialchars(stripslashes($_COOKIE['commentposter'])) : '';
	$ckmail = isset($_COOKIE['postermail']) ? $_COOKIE['postermail'] : '';
	$ckurl = isset($_COOKIE['posterurl']) ? $_COOKIE['posterurl'] : '';
	$comments = $emComment->getComment($logid);
	//trackback
	$tb = $emTrackback->getTrackback($logid);

	include getViews('header');
	require_once getViews('echo_log');
}

//添加评论
if ($action == 'addcom')
{
	$emComment = new emComment($DB);

	$comment = isset($_POST['comment']) ? addslashes(trim($_POST['comment'])) : '';
	$commail = isset($_POST['commail']) ? addslashes(trim($_POST['commail'])) : '';
	$comurl = isset($_POST['comurl']) ? addslashes(trim($_POST['comurl'])) : '';
	$comname = isset($_POST['comname']) ? addslashes(trim($_POST['comname'])) : '';
	$imgcode = strtoupper(trim(isset($_POST['imgcode']) ? $_POST['imgcode'] : ''));
	$gid = isset($_POST['gid']) ? intval($_POST['gid']) : '';

	$emComment->addComment($comname, $comment, $commail, $comurl, $imgcode, $comment_code, $ischkcomment, $localdate, $gid);

	$CACHE->mc_sta('sta');
	$CACHE->mc_comment('comments');
}
//test code
//$end_time=array_sum(explode(' ',microtime()));
//$runtime=number_format($end_time-$start_time,5);
//$query_num = $DB->query_num;
//print "runtime:$runtime(s) query:$query_num";
cleanPage()

?>
