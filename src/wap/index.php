<?php
/**
 * 手机wap页面
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.6.0
 */

error_reporting(E_ALL);

//$start_time=array_sum(explode(' ',microtime()));

require_once('../config.php');
require_once('../lib/F_base.php');
require_once('../lib/C_mysql.php');
require_once('../lib/C_cache.php');
require_once('../cache/config');
require_once('../cache/comments');
require_once('../cache/sta');
require_once('../cache/blogger');

//去除多余的转义字符
doStripslashes();
//数据库操作对象
$DB = new MySql($host, $user, $pass,$db);

$act = isset($_GET['act'])?addslashes($_GET['act']):'';
$index_lognum	    = $config_cache['index_lognum'];



if(!isset($act) || empty($act))
{
	wap_header($config_cache['blogname']);
	echo '<p>'.$config_cache['bloginfo'].'</p>';
	echo "<p>\n";
	echo "<a href=\"index.php?act=logs\">日志列表</a><br />\n";
	echo "<a href=\"index.php?act=tiw\">博主唠叨</a><br />\n";
	echo "<a href=\"index.php?act=coms\">最新评论</a><br />\n";
	echo "<br />\n";
	echo "日志({$sta_cache['lognum']})评论({$sta_cache['comnum']})引用({$sta_cache['tbnum']})<br />今日访问({$sta_cache['day_view_count']})总访问量({$sta_cache['view_count']})<br />\n";
	echo "</p>\n";
	wap_footer();
}


#################日志列表(display log list)##############
if ($act == 'logs')
{
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

	$sql =" SELECT * FROM {$db_prefix}blog WHERE hide='n' ORDER BY top DESC ,date DESC  LIMIT $start_limit, $index_lognum";
	$lognum = $sta_cache['lognum'];
	$pageurl= './index.php?act=logs&amp;page';
	$query = $DB->query($sql);
	while($row = $DB->fetch_array($query))
	{
		$row['post_time'] = date('Y-n-j G:i l',$row['date']);
		$row['log_title'] = htmlspecialchars(trim($row['title']));
		$row['logid']	  = $row['gid'];
		$log[] = $row;
	}
	//分页
	$page_url = pagination($lognum, $index_lognum, $page, $pageurl);

	wap_header($config_cache['blogname']);
	echo '<p>';
	foreach ($log as $val)
	{
		echo '<a href="./index.php?act=dis&amp;id='.$val['logid'].'">'.$val['log_title'].'</a>('.$val['views'].'/'.$val['comnum'].')<br />';
	}
	echo "</p><p>$page_url <br /><a href=\"./\">首页</a></p>";
	wap_footer();
}

#################显示日志(Display Logs)#################
if ($act == 'dis')
{
	//参数过滤
	isset($_GET['id']) ? $logid = intval($_GET['id']) : msg('提交参数错误','./index.php');
	$show_log = @$DB->fetch_one_array("SELECT * FROM {$db_prefix}blog WHERE gid='$logid' AND hide='n' ")
	OR msg('不存在该日志','./index.php');
	$DB->query("UPDATE {$db_prefix}blog SET views=views+1 WHERE gid='".$show_log['gid']."'");

	$log_title  = htmlspecialchars($show_log['title']);
	$log_author = $user_cache['name'];
	$post_time  = date('Y-n-j G:i l',$show_log['date']);
	$logid	    = intval($show_log['gid']);
	$log_content = rmBreak($show_log['content']);

	wap_header($log_title);
	echo "<p>发布时间：$post_time <br /></p>";
	echo "<p>$log_content</p>";
	echo "<p><a href=\"./\">首页</a> <a href=\"./?act=logs\">返回日志列表</a></p>";

	wap_footer();
}
if($act == 'coms')
{
	//decode comment
	if(isset($com_cache))
	{
		foreach($com_cache as $key=>$value)
		{
			$com_cache[$key]['name'] = base64_decode($com_cache[$key]['name']);
			$com_cache[$key]['content'] = base64_decode($com_cache[$key]['content']);
		}
	}else{
		$com_cache = array();
	}
	
	wap_header($config_cache['blogname']);
	foreach($com_cache as $value)
	{
		echo "{$value['name']}<br />{$value['content']}<br />";
	}
	echo "<p><a href=\"./\">首页</a></p>";
	wap_footer();
}

// WML文档头
function wap_header($title) {
	header("Content-type: text/vnd.wap.wml; charset=utf-8");
	echo "<?xml version=\"1.0\"?>\n";
	echo "<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.1//EN\" \"http://www.wapforum.org/ DTD/wml_1.1.xml\">\n\n";
	echo "<wml>\n";
	echo "<head>\n";
	echo "<meta http-equiv=\"cache-control\" content=\"max-age=180,private\" />\n";
	echo "</head>\n";
	echo "<card title=\"".$title."\">\n";
}

// WML文档尾
function wap_footer() {
	echo "</card>\n";
	echo "</wml>\n";
	exit;
}
?>