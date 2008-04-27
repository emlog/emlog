<?php
/**
 * 前端页面加载主程序
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.6.5
 */

require_once('./common.php');

viewCount();

//check template
$em_tpldir = $tpl_dir.$nonce_tpl.'/';//当前模板目录
if (!is_dir($em_tpldir))
{
	exit('Template Error: no template directory!');
}
//calendar url
$calendar_url = isset($_GET['date'])?"calendar.php?smp=$localdate&date=".$_GET['date']:"calendar.php?smp=$localdate";
$job = array('showlog','tag','search','addcom','taglog','');
if(!in_array($action,$job))
{
	msg('error!','./index.php');
}

#################日志列表(display log list)##############
if (!isset($action) || empty($action))
{
	include getViews('header');
	//page link
	$page = intval(isset($_GET['page']) ? $_GET['page'] : 1);
	if ($page)
	{
		$start_limit = ($page - 1) * $index_lognum;
		$id = ($page-1) * $index_lognum;
	}
	else
	{
		$start_limit = 0;
		$page = 1;
		$id = 0;
	}
	//是否为查询归档或日历对应日志
	$record = isset($_GET['record']) ? intval($_GET['record']) : '' ;
	if($record)
	{
		$add_query = "AND from_unixtime(date, '%Y%m%d') LIKE '%".$record."%'";
		$sql    = "SELECT * FROM {$db_prefix}blog WHERE hide='n'  $add_query ORDER BY top DESC ,date DESC  LIMIT $start_limit, $index_lognum";
		$query = $DB->query("SELECT gid FROM {$db_prefix}blog WHERE hide='n'  $add_query ");
		$lognum = $DB->num_rows($query);
		$pageurl= "./index.php?record=$record&page";
	}
	else
	{
		$sql =" SELECT * FROM {$db_prefix}blog WHERE hide='n' ORDER BY top DESC ,date DESC  LIMIT $start_limit, $index_lognum";
		$lognum = $sta_cache['lognum'];
		$pageurl= './index.php?page';
	}
	$query = $DB->query($sql);
	while($row = $DB->fetch_array($query))
	{
		$row['post_time'] = date('Y-n-j G:i l',$row['date']); 
		$row['log_title'] = htmlspecialchars(trim($row['title']));
		$row['logid']	  = $row['gid'];
		$row['log_description'] = breakLog($row['content'],$row['gid']);
		//attachment
		$row['attachment'] = !empty($log_cache_atts[$row['gid']]['attachment']) ? '<b>文件附件</b>:'.$log_cache_atts[$row['gid']]['attachment'] : '';
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
#################显示日志(Display Logs)#################
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
	$nextLogArr = @$DB->fetch_one_array("SELECT title,gid FROM {$db_prefix}blog WHERE gid < $logid AND hide='n' ORDER BY gid DESC  LIMIT 1");
	$nextLog = $isurlrewrite == 'n'?
				"<a href=\"./?action=showlog&gid={$nextLogArr['gid']}\">{$nextLogArr['title']}</a>":
				"<a href=\"./showlog-{$nextLogArr['gid']}.html\">{$nextLogArr['title']}</a>";
	$upLogArr = @$DB->fetch_one_array("SELECT title,gid FROM {$db_prefix}blog WHERE gid > $logid AND hide='n' LIMIT 1");
	$upLog = $isurlrewrite == 'n'?
				"<a href=\"./index.php?action=showlog&gid={$upLogArr['gid']}\">{$upLogArr['title']}</a>":
				"<a href=\"./showlog-{$upLogArr['gid']}.html\">{$upLogArr['title']}</a>";	
	if($nextLogArr && $upLogArr)
	{
		$neighborLog = "&laquo; {$upLog} | {$nextLog} &raquo";
	}elseif ($nextLogArr)
	{
		$neighborLog = "{$nextLog} &raquo";
	}elseif ($upLogArr)
	{
		$neighborLog = "&laquo; {$upLog}";
	}else 
	{
		$neighborLog = '';
	}
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
		$reply = htmlClean($s_com['reply']);
		$addtime = date('Y-m-d H:i',$s_com['date']);
		$cname   =  htmlspecialchars($s_com['poster']);	
		$poster  = $s_com['mail'] ? "<a href=\"mailto:{$s_com['mail']}\" title=\"发邮件给{$cname}\">$cname</a>" : $cname;
		$poster  = $s_com['url'] ? $poster." <a href=\"{$s_com['url']}\" title=\"访问{$cname}的主页\" target=\"_blank\">&raquo;</a>" : $poster;
		$com[]   = array(
						'content'=>$content,
						'reply'=>$reply,
						'addtime'=>$addtime,
						'cid'=>$s_com['cid'],
						'poster'=>$poster
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
#################搜索(search logs)#################
if($action == 'search')
{
	//参数过滤
	$keyword = isset($_GET['keyword']) ? addslashes(trim($_GET['keyword'])) : '';
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
			}
			else
			{
				$keywords_string = "LIKE '%".$keyword."%' ";
			}
	}
	$query  = "SELECT * FROM {$db_prefix}blog WHERE title $keywords_string AND hide='n' ORDER BY date DESC";
	$result = $DB->query($query);
	$search_num = $DB->num_rows($result);
	if($search_num > 0)
	{
		$search_info = '共检索到'.$search_num.'条记录';
		while($s_search = $DB->fetch_array($result))
		{
			$s_search['title'] = $s_search['title'];
			$s_search['gid']   = $s_search['gid'];
			$s_search['date']  = date('Y-m-d',$s_search['date']);
				
			$slog[] = $s_search;
		}
	}
	else
	{
		$search_info = '抱歉!你搜索的内容暂时不存在';
		$slog = array();
	}
	unset($s_search);
	include getViews('header');
	require_once getViews('search');
}
#################全部标签(all tags list)#################
if($action == 'tag')
{
	$tags = array();
	$tagmsg = '';
	$query = $DB->query("SELECT tagname,usenum FROM {$db_prefix}tag;");
	if($DB->num_rows($query) != 0)
	{
		while($s_tag = $DB->fetch_array($query))
		{
			$size = 14 + round($s_tag['usenum'] / 3);
			$size > 40 ? $fontsize = 40 : $fontsize = $size;
			$tag = $s_tag['tagname'];
			$tagurl = urlencode($s_tag['tagname']);
			$tags[] = array('fontsize'=>$fontsize,'tag'=>$tag,'tagurl'=>$tagurl);
		}
		unset($s_tag);
	}
	else
	{
		$tagmsg = '暂时没有任何标签(tag)';
	}
	include getViews('header');
	require_once getViews('tag');
}
#################查询标签对应日志#################
if($action == 'taglog')
{
	//参数过滤
	$tag = isset($_GET['tag']) ? addslashes(strval(trim($_GET['tag']))) : '';
	$tagstring = @$DB->fetch_one_array("SELECT tagname,gid FROM {$db_prefix}tag WHERE tagname='$tag' ") OR msg('不存在该标签','javascript:history.back(-1);');
	$gids  = substr(trim($tagstring['gid']),1,-1);
	$tag   = $tagstring['tagname'];
	$query = @$DB->query("SELECT title,gid,date FROM {$db_prefix}blog WHERE gid IN ($gids) AND hide='n' ORDER BY date DESC");
	while($s_tlog = $DB->fetch_array($query))
	{
		$s_tlog['title'] = htmlspecialchars($s_tlog['title']);
		$s_tlog['gid']   = intval($s_tlog['gid']);
		$s_tlog['date']  = date('Y-m-d',$s_tlog['date']);

		$taglogs[] = $s_tlog;
	}
	unset($s_tlog);
	include getViews('header');
	require_once getViews('tag_log');
}
#################添加评论(add comments)#################
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
	}
	elseif($commail!='' && !checkMail($commail))
	{
		msg('邮件格式错误!', 'javascript:history.back(-1);');
	}
	elseif(strlen($comment)=='' || strlen($comment)>2000)
	{
		msg('评论内容非法','javascript:history.back(-1);');
	}
	elseif($imgcode=='' && $comment_code=='y')
	{
		msg('验证码不能为空','javascript:history.back(-1);');
	}
	elseif($comment_code=='y' && $imgcode != $_SESSION['code'])
	{
		msg('验证码错误!','javascript:history.back(-1);');
	}
	else 
	{
		$sql = "INSERT INTO {$db_prefix}comment (date,poster,gid,comment,reply,mail,url,hide) VALUES ('$localdate','$comname','$gid','$comment','','$commail','$comurl','$ischkcomment')";
		$ret = $DB->query($sql);
		if($ischkcomment == 'n')
		{
			$DB->query("UPDATE {$db_prefix}blog SET comnum = comnum + 1 WHERE gid='$gid'");
			$MC->mc_sta('./cache/sta');
			$MC->mc_comment('./cache/comments');
			msg('评论发表成功!',"?action=showlog&gid=$gid#comment");
		}
		else
		{
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