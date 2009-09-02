<?php
/**
 * 手机 wap
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.3.0
 * $Id:  526 2008-07-05 15:21:03Z emloog $
 */

require_once('../common.php');
$isgzipenable = 'n';//wap浏览关闭gzip压缩
$tem = time();
if(!isset($action) || empty($action))
{
	wap_header($options_cache['blogname']);
	echo '<p>'.$options_cache['bloginfo'].'</p>';
	echo "<p>\n";
	echo "<a href=\"./?action=logs&amp;tem=$tem\">".$lang['blog_view']."</a><br />\n";
	echo "<a href=\"./?action=twitter&amp;tem=$tem\">".$lang['twitter']."</a><br />\n";
	echo "<a href=\"./?action=coms&amp;tem=$tem\">".$lang['latest_comments']."</a><br />\n";
	echo "<br />\n";
	if(ROLE == 'admin')
	{
		echo $lang['welcome_login']."<br />\n";
		echo "<a href=\"./?action=addtw\">".$lang['twitter_add']."</a><br />\n";
		echo "<a href=\"./?action=logout\">".$lang['logout']."</a><br />\n";
	}else {
		echo "<a href=\"./?action=waplogin\">".$lang['login']."</a><br />\n";
	}
	echo "<br />\n";
	echo $lang['number_of_posts'].": {$sta_cache['lognum']}, {$lang['number_of_comments']}: {$sta_cache['comnum']}, {$lang['number_of_trackbacks']}: {$sta_cache['tbnum']}<br />".
             $lang['visits_today'].": {$viewcount_day}, {$lang['visits_total']}: {$viewcount_all}<br />\n";
	echo "</p>\n";
	wap_footer();
}
//显示日志列表 blog list
if ($action == 'logs')
{
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	if ($page)
	{
		$start_limit = ($page - 1) * $index_lognum;
		$id = ($page-1) * $index_lognum;
	}else{
		$start_limit = 0;
		$page = 1;
		$id = 0;
	}
	$sql = " SELECT * FROM ".DB_PREFIX."blog WHERE hide='n' and type='blog' ORDER BY top DESC ,date DESC LIMIT $start_limit, $index_lognum";
	$lognum = $sta_cache['lognum'];
	$pageurl = './?action=logs&amp;page';
	$query = $DB->query($sql);
	while($row = $DB->fetch_array($query))
	{
		$row['post_time'] = date('Y-n-j G:i l',$row['date']);
		$row['log_title'] = htmlspecialchars(trim($row['title']));
		$row['logid']	  = $row['gid'];
		$log[] = $row;
	}
	$page_url = pagination($lognum, $index_lognum, $page, $pageurl);
	wap_header($options_cache['blogname']);
	echo '<p>';
	if(isset($log))
	{
		foreach ($log as $val)
		{
			echo '<a href="./?action=dis&amp;id='.$val['logid'].'">'.$val['log_title'].'</a>('.$val['views'].'/'.$val['comnum'].')<br />';
		}
	}else{
		echo 'No logs yet!';
	}
	echo "</p><p>$page_url <br /><a href=\"./?tem=$tem\">".$lang['home']."</a></p>";
	wap_footer();
}
//显示日志
if ($action == 'dis')
{
	isset($_GET['id']) ? $logid = intval($_GET['id']) : emMsg($lang['parameter_invalid'],'./');

	$show_log = @$DB->once_fetch_array("SELECT * FROM ".DB_PREFIX."blog WHERE gid='$logid' AND hide='n' ")
	OR emMsg($lang['post_not_exists'],'./');
	if(!empty($show_log['password']))
	{
		$logpwd = isset($_POST['pw']) ? addslashes(trim($_POST['pw'])) : '';
		AuthPassword($show_log['password'], $logpwd, $show_log['gid']);
	}
	$DB->query("UPDATE ".DB_PREFIX."blog SET views=views+1 WHERE gid='".$show_log['gid']."'");

	$log_title  = htmlspecialchars($show_log['title']);
	$log_author = $user_cache[$show_log['author']]['name'];
	$post_time  = date('Y-n-j G:i l',$show_log['date']);
	$logid	    = intval($show_log['gid']);
	$log_content = rmBreak($show_log['content']);

	wap_header($log_title);
	echo "<p>{$lang['post_time']}: $post_time <br />{$lang['author']}: $log_author <br /></p>";
	echo "<p>$log_content</p>";
	echo "<p><a href=\"./?tem=$tem\">{$lang['home']}</a> <a href=\"./?action=logs\">{$lang['back_to_list']}</a></p>";

	wap_footer();
}
if($action == 'coms')
{
	wap_header($options_cache['blogname']);
	if(isset($com_cache) && !empty($com_cache))
	{
		foreach($com_cache as $value)
		{
			echo "{$value['name']}<br />{$value['content']}<br />";
		}
	}else{
		echo 'No comments yet!';
	}
	echo "<p><a href=\"./?tem=$tem\">{$lang['home']}</a></p>";
	wap_footer();
}
//twitter list
if ($action == 'twitter')
{
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	if ($page)
	{
		$start_limit = ($page - 1) * $index_twnum;
		$id = ($page-1) * $index_twnum;
	}else{
		$start_limit = 0;
		$page = 1;
		$id = 0;
	}
	$sql =" SELECT * FROM ".DB_PREFIX."twitter ORDER BY id DESC  LIMIT $start_limit, $index_twnum";
	$twnum = $sta_cache['twnum'];
	$pageurl= './?action=twitter&amp;page';
	$query = $DB->query($sql);
	while($row = $DB->fetch_array($query))
	{
		$row['date'] = smartyDate($row['date']);
		$row['content'] = htmlspecialchars(trim($row['content']));
		$tws[] = $row;
	}
	$page_url = pagination($twnum, $index_twnum, $page, $pageurl);

	wap_header($options_cache['blogname']);
	echo '<p>';
	if(isset($tws))
	{
		foreach ($tws as $val)
		{
			$doact = ROLE == 'admin' ? "<a href=\"./?action=del_tw&amp;id=".$val['id']."\">{$lang['remove']}</a>" : '';
			echo $val['content'].$doact.'('.$val['date'].')<br />';
		}
	}else{
		echo $lang['no_twitter_yet']';
	}
	echo "</p><p>$page_url <br /><a href=\"./?tem=$tem\">{$lang['home']}</a></p>";
	wap_footer();
}
if ($action == 'addtw')
{
	wap_header('Twitter');
	echo "<p>{$lang['content']}:<br /><input name=\"tw\" type=\"text\"  format=\"M*m\"/></p>\n";
	echo "<p><anchor title=\"submit\">{$lang['submit']}\n";
	echo "<go href=\"./?action=add_tw\" method=\"post\">\n";
	echo "<postfield name=\"tw\" value=\"$(tw)\" />\n";
	echo "<postfield name=\"do\" value=\"dowaplogin\" />\n";
	echo "</go></anchor>\n";
	echo "</p>\n";
	echo "<p><a href=\"?tem=$tem\">{$lang['back_home']}</a></p>\n";
	wap_footer();
}
//新增 twitter
if(ROLE == 'admin' && $action == 'add_tw')
{
	$content = isset($_POST['tw']) ? addslashes($_POST['tw']) : '';
	if(!empty($content))
	{
		$query = $DB->query("INSERT INTO ".DB_PREFIX."twitter (content,date) VALUES('$content','$localdate')");
		$CACHE->mc_twitter();
		$CACHE->mc_sta();
		header("Location: ?action=twitter&amp;tem=$time");
	}
}
//删除 twitter
if(ROLE == 'admin' && $action == 'del_tw')
{
	$twid = isset($_GET['id']) ? intval($_GET['id']) : '';
	$query = $DB->query("DELETE FROM ".DB_PREFIX."twitter WHERE id=$twid");
	$CACHE->mc_twitter();
	$CACHE->mc_sta();
	header("Location: ?action=twitter");
}
if ($action == 'waplogin')
{
	wap_header($lang['login']);
	echo "<p>{$lang['user_name']}: <input name=\"user\" type=\"text\"  format=\"M*m\"/></p>\n";
	echo "<p>{$lang['password']}: <input name=\"pw\" type=\"password\"  format=\"M*m\"/></p>\n";
	echo "<p><anchor title=\"submit\">{$lang['login']}\n";
	echo "<go href=\"./?action=dowaplogin\" method=\"post\">\n";
	echo "<postfield name=\"user\" value=\"$(user)\" />\n";
	echo "<postfield name=\"pw\" value=\"$(pw)\" />\n";
	echo "<postfield name=\"do\" value=\"dowaplogin\" />\n";
	echo "</go></anchor>\n";
	echo "</p>\n";
	echo "<p><a href=\"?tem=$tem\">{$lang['back_home']}</a></p>\n";
	wap_footer();
}
//登录验证
if ($action == 'dowaplogin')
{
	session_start();
	$username = addslashes(trim($_POST['user']));
	$password = addslashes(trim($_POST['pw']));
	$ispersis = true;
	if (checkUser($username, $password, '', 'n') === true)
	{
		setAuthCookie($username, $ispersis);
		header("Location: ?tem=$tem");
	}else{
		header("Location: ?action=waplogin&amp;tem=$tem");
	}
}
//登出
if ($action == 'logout')
{
	session_start();
	session_unset();
	session_destroy();
	setcookie(AUTH_COOKIE_NAME, ' ', time() - 31536000, '/');
	header("Location: ?tem=$tem");
}
//WML 头
function wap_header($title) {
	header('Content-type: text/vnd.wap.wml; charset=utf-8');
	echo "<?xml version=\"1.0\"?>\n";
	echo "<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.1//EN\" \"http://www.wapforum.org/ DTD/wml_1.1.xml\">\n\n";
	echo "<wml>\n";
	echo "<head>\n";
	echo "<meta http-equiv=\"cache-control\" content=\"max-age=180,private\" />\n";
	echo "</head>\n";
	echo "<card title=\"".$title."\">\n";
}
//WML 尾
function wap_footer() {
	echo "</card>\n";
	echo "</wml>\n";
	exit;
}
//验证日志密码
function authPassword($pwd, $pwd2, $blogid)
{
	if($pwd !== $pwd2)
	{
		wap_header($lang['blog_enter_password']);
		echo "<p>{$lang['password']}: <input name=\"pw\" type=\"password\"  format=\"M*m\"/></p>\n";
		echo "<p><anchor title=\"submit\">{$lang['submit']}\n";
		echo "<go href=\"./?action=dis&amp;id=".$blogid."\" method=\"post\">\n";
		echo "<postfield name=\"pw\" value=\"$(pw)\" />\n";
		echo "<postfield name=\"do\" value=\"\" />\n";
		echo "</go></anchor>\n";
		echo "</p>\n";
		echo "<p><a href=\"./?action=logs\">{$lang['back_to_list']}</a></p>\n";
		wap_footer();
		exit;
	}
}

?>