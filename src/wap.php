<?php
/**
 * 手机 wap 第一版
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.7.0
 * $Id: wap.php 526 2008-07-05 15:21:03Z emloog $
 */

require_once('./common.php');

define('CURPAGE','wap');

if(!isset($action) || empty($action))
{
	wap_header($config_cache['blogname']);
	echo '<p>'.$config_cache['bloginfo'].'</p>';
	echo "<p>\n";
	echo "<a href=\"wap.php?action=logs\">浏览日志</a><br />\n";
	echo "<a href=\"wap.php?action=twitter\">博主唠叨</a><br />\n";
	echo "<a href=\"wap.php?action=coms\">最新评论</a><br />\n";
	echo "<br />\n";
	if(ISLOGIN === true)
	{
		echo "欢迎你,你已登录<br />\n";
		echo "<a href=\"wap.php?action=addtw\">唠叨两句</a><br />\n";
		echo "<a href=\"wap.php?action=logout\">退出</a><br />\n";
	}else {
		echo "<a href=\"wap.php?action=waplogin\">登录</a><br />\n";
	}
	echo "<br />\n";
	echo "日志({$sta_cache['lognum']})评论({$sta_cache['comnum']})引用({$sta_cache['tbnum']})<br />今日访问({$sta_cache['day_view_count']})总访问量({$sta_cache['view_count']})<br />\n";
	echo "</p>\n";
	wap_footer();
}

//显示日志列表 blog list
if ($action == 'logs')
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
	$pageurl= './wap.php?action=logs&amp;page';
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
	if(isset($log))
	{
		foreach ($log as $val)
		{
			echo '<a href="./wap.php?action=dis&amp;id='.$val['logid'].'">'.$val['log_title'].'</a>('.$val['views'].'/'.$val['comnum'].')<br />';
		}
	}else
	{
		echo 'No logs yet!';
	}
	echo "</p><p>$page_url <br /><a href=\"./wap.php\">首页</a></p>";
	wap_footer();
}

//显示日志 Display Log
if ($action == 'dis')
{
	//参数过滤
	isset($_GET['id']) ? $logid = intval($_GET['id']) : msg('提交参数错误','./wap.php');
	$show_log = @$DB->fetch_one_array("SELECT * FROM {$db_prefix}blog WHERE gid='$logid' AND hide='n' ")
	OR msg('不存在该日志','./wap.php');
	$DB->query("UPDATE {$db_prefix}blog SET views=views+1 WHERE gid='".$show_log['gid']."'");

	$log_title  = htmlspecialchars($show_log['title']);
	$log_author = $user_cache['name'];
	$post_time  = date('Y-n-j G:i l',$show_log['date']);
	$logid	    = intval($show_log['gid']);
	$log_content = rmBreak($show_log['content']);

	wap_header($log_title);
	echo "<p>发布时间：$post_time <br /></p>";
	echo "<p>$log_content</p>";
	$stamp = time();
	echo "<p><a href=\"./wap.php?stamp=$stamp\">首页</a> <a href=\"./?action=logs\">返回日志列表</a></p>";

	wap_footer();
}
if($action == 'coms')
{
	wap_header($config_cache['blogname']);
	if(isset($com_cache) && !empty($com_cache))
	{
		foreach($com_cache as $value)
		{
			echo "{$value['name']}<br />{$value['content']}<br />";
		}
	}else
	{
		echo 'No comments yet!';
	}
	echo "<p><a href=\"./wap.php\">首页</a></p>";
	wap_footer();
}
//twitter list
if ($action == 'twitter')
{
	//page link
	$page = intval(isset($_GET['page']) ? $_GET['page'] : 1);
	if ($page)
	{
		$start_limit = ($page - 1) * $index_twnum;
		$id = ($page-1) * $index_twnum;
	}
	else
	{
		$start_limit = 0;
		$page = 1;
		$id = 0;
	}

	$sql =" SELECT * FROM {$db_prefix}twitter ORDER BY id DESC  LIMIT $start_limit, $index_twnum";
	$twnum = $sta_cache['twnum'];
	$pageurl= './wap.php?action=twitter&amp;page';
	$query = $DB->query($sql);
	while($row = $DB->fetch_array($query))
	{
		$row['date'] = smartyDate($localdate,$row['date']);
		$row['content'] = htmlspecialchars(trim($row['content']));
		$tws[] = $row;
	}
	//分页
	$page_url = pagination($twnum, $index_twnum, $page, $pageurl);

	wap_header($config_cache['blogname']);
	echo '<p>';
	if(isset($tws))
	{
		foreach ($tws as $val)
		{
			$doact = ISLOGIN===true?"<a href=\"./wap.php?action=del_tw&amp;id=".$val['id']."\">删除</a>":'';
			echo $val['content'].$doact.'('.$val['date'].')<br />';
		}
	}else
	{
		echo 'No twitter yet!';
	}
	$stamp = time();
	echo "</p><p>$page_url <br /><a href=\"./wap.php?stamp=$stamp\">首页</a></p>";
	wap_footer();
}
if ($action == 'waplogin')
{
	wap_header('用户登录');
	echo "<p>用户:<input name=\"user\" type=\"text\"  format=\"M*m\"/></p>\n";
	echo "<p>密码:<input name=\"pw\" type=\"password\"  format=\"M*m\"/></p>\n";
	echo "<p><anchor title=\"submit\">登录\n";
	echo "<go href=\"wap.php?action=login\" method=\"post\">\n";
	echo "<postfield name=\"user\" value=\"$(user)\" />\n";
	echo "<postfield name=\"pw\" value=\"$(pw)\" />\n";
	echo "<postfield name=\"do\" value=\"dowaplogin\" />\n";
	echo "</go></anchor>\n";
	echo "</p>\n";
	echo "<p><a href=\"wap.php\">返回主页</a></p>\n";
	wap_footer();
}
if ($action == 'addtw')
{
	wap_header('Twitter');
	echo "<p>内容:<br /><input name=\"tw\" type=\"text\"  format=\"M*m\"/></p>\n";
	echo "<p><anchor title=\"submit\">提交\n";
	echo "<go href=\"wap.php?action=add_tw\" method=\"post\">\n";
	echo "<postfield name=\"tw\" value=\"$(tw)\" />\n";
	echo "<postfield name=\"do\" value=\"dowaplogin\" />\n";
	echo "</go></anchor>\n";
	echo "</p>\n";
	echo "<p><a href=\"wap.php\">返回主页</a></p>\n";
	wap_footer();
}
//新增 twitter
if(ISLOGIN === true && $action == 'add_tw')
{
	$content = isset($_POST['tw'])?addslashes($_POST['tw']):'';
	if(!empty($content))
	{
		$query = $DB->query("INSERT INTO {$db_prefix}twitter (content,date) VALUES('$content','$localdate')");
		$MC->mc_twitter('../cache/twitter');
		$MC->mc_sta('../cache/sta');
		header("Location: wap.php?action=twitter&amp;stamp=$time");
	}
}
//删除 twitter
if(ISLOGIN === true && $action == 'del_tw')
{
	$twid = isset($_GET['id'])?intval($_GET['id']):'';
	$query = $DB->query("DELETE FROM {$db_prefix}twitter WHERE id=$twid");
	$MC->mc_twitter('../cache/twitter');
	$MC->mc_sta('../cache/sta');
	header("Location: wap.php?action=twitter");
}
//登陆验证
if ($action == 'dowaplogin')
{
	session_start();
	$username = addslashes(trim($_POST['user']));
	$password = md5(addslashes(trim($_POST['pw'])));
	$login_code = 'n';
	$login_code == 'y'?$img_code = addslashes(trim(strtoupper($_POST['imgcode']))):$img_code = '';
	if (strlen($username) >16)
	{
		header("Location: wap.php");
	}
	if (checkUser($username, $password,$img_code,$login_code))
	{
		if (function_exists('session_regenerate_id'))//PHP_VERSION >= '4.3.2'
		{
			session_regenerate_id();
		}
		$_SESSION['adminname'] = $username;
		$_SESSION['password'] = $password;
		$stamp = time();
		header("Location: wap.php?stamp=$stamp");
	}else
	{
		header("Location: wap.php");
	}
}

// WML 头
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

// WML 尾
function wap_footer() {
	echo "</card>\n";
	echo "</wml>\n";
	exit;
}

?>