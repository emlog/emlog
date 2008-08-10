<?php
/**
 * 前端页面加载主程序
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.7.0
 * $Id$
 */

require_once('./common.php');

define('CURPAGE','index');

viewCount();

//check template
$em_tpldir = $tpl_dir.$nonce_templet.'/';//当前模板目录
if (!is_dir($em_tpldir))
{
	exit('Template Error: no template directory!');
}
//calendar url
$calendar_url = isset($_GET['record'])? "calendar.php?record=".$_GET['record']:"calendar.php?";
$job = array('showlog','search','addcom','taglog','');
if(!in_array($action,$job))
{
	msg('error!','./index.php');
}
$blogtitle = $blogname;

//日志列表
if (!isset($action) || empty($action))
{
	include getViews('header');

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
	if($record)
	{
		$add_query = "AND from_unixtime(date, '%Y%m%d') LIKE '%".$record."%'";
		$sql = "SELECT * FROM {$db_prefix}blog WHERE hide='n'  $add_query ORDER BY top DESC ,date DESC LIMIT $start_limit, $index_lognum";
		$query = $DB->query("SELECT gid FROM {$db_prefix}blog WHERE hide='n'  $add_query ");
		$lognum = $DB->num_rows($query);
		$pageurl .= "?record=$record&page";
	}elseif($tag){
		$tagstring = @$DB->fetch_one_array("SELECT tagname,gid FROM {$db_prefix}tag WHERE tagname='$tag' ") OR msg('不存在该标签','javascript:history.back(-1);');
		$gids  = substr(trim($tagstring['gid']),1,-1);
		$tag   = $tagstring['tagname'];
		$sql = "SELECT * FROM {$db_prefix}blog WHERE gid IN ($gids) AND hide='n'";
		$query = $DB->query($sql);
		$lognum = $DB->num_rows($query);
		$sql .= " ORDER BY date DESC LIMIT $start_limit, $index_lognum";
		$pageurl .= "?tag=$tag&page";
	}elseif($keyword){
		//参数过滤
		$keyword = str_replace('%','\%',$keyword);
		$keyword = str_replace('_','\_',$keyword);
		if(strlen($keyword)>30 || strlen($keyword)<3)
		{
			msg('关键字长度不能小于3个字节!','./index.php');
		}
		//分割关键字
		$keywords = explode(' ',$keyword);
		for($i=0; $i<count($keywords); $i++)
		{
			$keyword=$keywords[$i];
			if($i)
			{
				$keywords_string .= "OR title like '%".$keyword."%' ";
			}else{
				$keywords_string = "LIKE '%".$keyword."%' ";
			}
		}
		$sql = "SELECT * FROM {$db_prefix}blog WHERE title $keywords_string AND hide='n'";
		$query = $DB->query($sql);
		$lognum = $DB->num_rows($query);
		$sql .= " ORDER BY date DESC LIMIT $start_limit, $index_lognum";
		$pageurl .= "?keyword=$keyword&page";
	}else{
		$sql =" SELECT * FROM {$db_prefix}blog WHERE hide='n' ORDER BY top DESC ,date DESC  LIMIT $start_limit, $index_lognum";
		$lognum = $sta_cache['lognum'];
		$pageurl .= "?page";
	}
	$logs = array();
	$query = $DB->query($sql);
	while($row = $DB->fetch_array($query))
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
		$row['toplog'] = $row['top'] == 'y' ? "<img src=\"./images/import.gif\" align=\"absmiddle\"  alt=\"推荐日志\" />" : '';
		$logs[] = $row;
	}
	//分页
	$page_url = pagination($lognum, $index_lognum, $page, $pageurl);

	include getViews('log_list');
}

//显示日志
if ($action == 'showlog')
{
	//参数过滤
	isset($_GET['gid']) ? $logid = intval($_GET['gid']) : msg('提交参数错误','./index.php');
	$show_log = @$DB->fetch_one_array("SELECT * FROM {$db_prefix}blog WHERE gid='$logid' AND hide='n' ")
	OR msg('不存在该日志','./index.php');
	$DB->query("UPDATE {$db_prefix}blog SET views=views+1 WHERE gid='".$show_log['gid']."'");
	$blogtitle  = htmlspecialchars($show_log['title']);
	$log_title  = htmlspecialchars($show_log['title']);
	$log_author = $user_cache['name'];
	$post_time  = date('Y-n-j G:i l',$show_log['date']);
	$logid	    = intval($show_log['gid']);
	$blogurl    = $blogurl;
	$tbscode	= substr(md5(date('Ynd')),0,5);
	$log_content = rmBreak($show_log['content']);
	$allow_remark = $show_log['allow_remark'];
	$allow_tb = $show_log['allow_tb'];
	//邻近日志
	$nextLog = @$DB->fetch_one_array("SELECT title,gid FROM {$db_prefix}blog WHERE gid < $logid AND hide='n' ORDER BY gid DESC  LIMIT 1");
	$previousLog = @$DB->fetch_one_array("SELECT title,gid FROM {$db_prefix}blog WHERE gid > $logid AND hide='n' LIMIT 1");
	//标签
	$tag = !empty($log_cache_tags[$logid]) ? '标签:'.$log_cache_tags[$logid] : '';
	//附件
	$attachment = !empty($log_cache_atts[$logid]['attachment']) ? '<b>文件附件</b>:'.$log_cache_atts[$logid]['attachment'] : '';
	$att_img = !empty($log_cache_atts[$logid]['att_img']) ? $log_cache_atts[$logid]['att_img'] : '';
	//评论
	$cheackimg = $comment_code=='y' ? "<img src=\"./lib/C_checkcode.php\" align=\"absmiddle\" /><input name=\"imgcode\"  type=\"text\" class=\"input\" size=\"5\">" : '';
	$ckname = isset($_COOKIE['commentposter']) ? htmlspecialchars(stripslashes($_COOKIE['commentposter'])): '';
	$ckmail = isset($_COOKIE['postermail']) ? $_COOKIE['postermail'] : '';
	$ckurl = isset($_COOKIE['posterurl']) ? $_COOKIE['posterurl'] : '';

	$com = array();
	$query = $DB->query("SELECT * FROM {$db_prefix}comment WHERE gid=$logid AND hide='n' ORDER BY cid ");
	while($s_com = $DB->fetch_array($query))
	{
		$content = htmlClean($s_com['comment']);
		$reply = $s_com['reply'];
		$addtime = date('Y-m-d H:i',$s_com['date']);
		$cname   =  htmlspecialchars($s_com['poster']);
		$s_com['mail'] = htmlspecialchars($s_com['mail']);
		$s_com['url'] = htmlspecialchars($s_com['url']);
		$com[]   = array(
		'content'=>$content,
		'reply'=>$reply,
		'addtime'=>$addtime,
		'cid'=>$s_com['cid'],
		'poster'=>$cname,
		'mail'=>$s_com['mail'],
		'url'=>$s_com['url']
		);
	}
	unset($s_com);
	//trackback
	$tb = array();
	$query =$DB->query("SELECT *FROM {$db_prefix}trackback WHERE gid=$logid ORDER BY tbid ");
	while($s_tb = $DB->fetch_array($query))
	{
		$s_tb['url']       = htmlspecialchars($s_tb['url']);
		$s_tb['title']     = htmlspecialchars($s_tb['title']);
		$s_tb['blog_name'] = htmlspecialchars($s_tb['blog_name']);
		$s_tb['excerpt']   = htmlspecialchars($s_tb['excerpt']);
		$s_tb['date']      = date('Y-m-d H:i',$s_tb['date']);

		$tb[] = $s_tb;
	}
	unset($s_tb);
	include getViews('header');
	require_once getViews('echo_log');
}

//添加评论
if($action == 'addcom')
{
	$comment = isset($_POST['comment']) ? addslashes(trim($_POST['comment'])) : '';
	$commail = isset($_POST['commail']) ? addslashes(trim($_POST['commail'])) : '';
	$comurl = isset($_POST['comurl']) ? addslashes(trim($_POST['comurl'])) : '';
	$comname = isset($_POST['comname']) ? addslashes(trim($_POST['comname'])) : '';
	$imgcode = strtoupper(trim(isset($_POST['imgcode']) ? $_POST['imgcode']:''));
	$gid = isset($_POST['gid']) ? intval($_POST['gid']) : '';
	$remember = isset($_POST['remember'])?intval($_POST['remember']):'';

	if($comurl && strncasecmp($comurl,'http://',7))//0 if they are equal
	{
		$comurl = 'http://'.$comurl;
	}
	//COOKIE
	if($remember == 1)
	{
		$cookietime = $localdate + 31536000;
		setcookie('commentposter',$comname,$cookietime);
		setcookie('postermail',$commail,$cookietime);
		setcookie('posterurl',$comurl,$cookietime);
	}
	//can comment?
	$query = $DB->query("SELECT allow_remark FROM {$db_prefix}blog WHERE gid=$gid");
	$show_remark = $DB->fetch_array($query);
	if($show_remark['allow_remark']=='n')
	{
		msg('该日志不接受评论','javascript:history.back(-1);');
	}
	//is same comment?
	$query = $DB->query("SELECT cid FROM {$db_prefix}comment
									WHERE gid='".$gid."' 
									AND poster='".$comname."' 
									AND comment='".$comment."' ");
	$result = $DB->num_rows($query);
	if($result > 0)
	{
		msg('评论已存在','javascript:history.back(-1);');
	}
	if(preg_match("/['<>,#|;\/\$\\&\r\t()%@+?^]/",$comname) || strlen($comname)>20 || strlen($comname)==0)
	{
		msg('姓名非法!','javascript:history.back(-1);');
	}elseif($commail!='' && !checkMail($commail)){
		msg('邮件格式错误!', 'javascript:history.back(-1);');
	}elseif(strlen($comment)=='' || strlen($comment)>2000){
		msg('评论内容非法','javascript:history.back(-1);');
	}elseif($imgcode=='' && $comment_code=='y'){
		msg('验证码不能为空','javascript:history.back(-1);');
	}elseif($comment_code=='y' && $imgcode != $_SESSION['code']){
		msg('验证码错误!','javascript:history.back(-1);');
	}else{
		$sql = "INSERT INTO {$db_prefix}comment (date,poster,gid,comment,reply,mail,url,hide) VALUES ('$localdate','$comname','$gid','$comment','','$commail','$comurl','$ischkcomment')";
		$ret = $DB->query($sql);
		if($ischkcomment == 'n')
		{
			$DB->query("UPDATE {$db_prefix}blog SET comnum = comnum + 1 WHERE gid='$gid'");
			$MC->mc_sta('./cache/sta');
			$MC->mc_comment('./cache/comments');
			msg('评论发表成功!',"?action=showlog&gid=$gid#comment");
		}else{
			$MC->mc_sta('./cache/sta');
			msg('评论发表成功!请等待管理员审核!',"?action=showlog&gid=$gid#comment");
		}
	}
}
//test code
//$end_time=array_sum(explode(' ',microtime()));
//$runtime=number_format($end_time-$start_time,5);
//$query_num = $DB->query_num;
//print "runtime:$runtime(s) query:$query_num";
cleanPage()
?>