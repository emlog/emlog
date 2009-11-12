<?php
/**
 * mobile 版本
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.3.0
 * $Id:  526 2008-07-05 15:21:03Z emloog $
 */

require_once ('../common.php');

$isgzipenable = 'n'; //手机浏览关闭gzip压缩
$index_lognum = 5;
$index_twnum = 5;

define ('TEMPLATE_PATH', EMLOG_ROOT . '/m/view/'); //模板路径


$logid = isset ($_GET ['post']) ? intval ($_GET ['post']) : '';
$blogname = $options_cache ['blogname'];
$blogdes = $options_cache ['bloginfo'];

if (empty ($action) && empty ($logid)) {
	require_once (EMLOG_ROOT . '/model/class.blog.php');
	
	$emBlog = new emBlog ($DB);
	$page = isset ($_GET ['page']) ? abs (intval ($_GET ['page'])) : 1;
	$sqlSegment = "ORDER BY top DESC ,date DESC";
	$lognum = $sta_cache ['lognum'];
	$pageurl = '?page';
	$logs = $emBlog->getLogsForHome ($sqlSegment, $page, $index_lognum);
	$page_url = pagination ($lognum, $index_lognum, $page, $pageurl);
	
	include getViews ('header');
	include getViews ('log');
	include getViews ('footer');
}
//显示日志
if (! empty ($logid)) {
	require_once (EMLOG_ROOT . '/model/class.blog.php');
	require_once (EMLOG_ROOT . '/model/class.comment.php');
	
	$emBlog = new emBlog ($DB);
	$emComment = new emComment ($DB);
	
	$logData = $emBlog->getOneLogForHome ($logid);
	if ($logData === false) {
		exit ('不存在该条目');
	}
	extract ($logData);
	if (! empty ($password)) {
		$postpwd = isset ($_POST ['logpwd']) ? addslashes (trim ($_POST ['logpwd'])) : '';
		$cookiepwd = isset ($_COOKIE ['em_logpwd_' . $logid]) ? addslashes (trim ($_COOKIE ['em_logpwd_' . $logid])) : '';
		$emBlog->AuthPassword ($postpwd, $cookiepwd, $password, $logid);
	}
	$blogtitle = $log_title . ' - ' . $blogname;
	//comments
	$cheackimg = $comment_code == 'y' ? "<img src=\"./lib/checkcode.php\" align=\"absmiddle\" /><input name=\"imgcode\"  type=\"text\" class=\"input\" size=\"5\">" : '';
	$comments = $emComment->getComments (0, $logid, 'n');
	
	$emBlog->updateViewCount ($logid);
	include getViews ('header');
	include getViews ('single');
	include getViews ('footer');
}
//写日志页
if (ISLOGIN === true && $action == 'write') {
	$logid = isset($_GET['id']) ? intval($_GET['id']) : '';
	require_once(EMLOG_ROOT.'/model/class.sort.php');
	$emSort = new emSort($DB);
	$sorts = $emSort->getSorts();
	if($logid)
	{
		require_once(EMLOG_ROOT.'/model/class.blog.php');
		require_once(EMLOG_ROOT.'/model/class.tag.php');
		$emBlog = new emBlog($DB);
		$emTag = new emTag($DB);
	
		$blogData = $emBlog->getOneLogForAdmin($logid);
		extract($blogData);
		$tags = array();
		foreach ($emTag->getTag($logid) as $val)
		{
			$tags[] = $val['tagname'];
		}
		$tagStr = implode(',', $tags);
	}else{
		$title = '';
		$sortid = -1;
		$content = '';
		$tagStr = '';
		$logid = -1;
		$author = UID;
	}
	include getViews ('header');
	include getViews ('write');
	include getViews ('footer');
}
//保存日志
if (ISLOGIN === true && $action == 'savelog') {
	require_once(EMLOG_ROOT.'/model/class.blog.php');
	require_once(EMLOG_ROOT.'/model/class.tag.php');

	$emBlog = new emBlog($DB);
	$emTag = new emTag($DB);

	$title = isset($_POST['title']) ? addslashes(trim($_POST['title'])) : '';
	$sort = isset($_POST['sort']) ? intval($_POST['sort']) : '';
	$content = isset($_POST['content']) ? addslashes(trim($_POST['content'])) : '';
	$tagstring = isset($_POST['tag']) ? addslashes(trim($_POST['tag'])) : '';
	$blogid = isset($_POST['as_logid']) ? intval(trim($_POST['as_logid'])) : -1;
	$author = isset($_POST['author']) ? intval(trim($_POST['author'])) : UID;
	$postTime = $emBlog->postDate($timezone);

	$logData = array(
		'title'=>$title,
		'content'=>$content,
		'excerpt'=>'',
		'author'=>$author,
		'sortid'=>$sort,
		'date'=>$postTime,
		'allow_remark'=>'y',
		'allow_tb'=>'y',
		'hide'=>'n',
		'password'=>''
	);
	
	if($blogid > 0)
	{
		$emBlog->updateLog($logData, $blogid);
		$emTag->updateTag($tagstring, $blogid);
	}else{
		$blogid = $emBlog->addlog($logData);
		$emTag->addTag($tagstring, $blogid);
	}

	$CACHE->mc_logtags();
	$CACHE->mc_logatts();
	$CACHE->mc_logsort();
	$CACHE->mc_record();
	$CACHE->mc_newlog();
	$CACHE->mc_sort();
	$CACHE->mc_tags();
	$CACHE->mc_user();
	$CACHE->mc_sta();
	header ("Location: ./");
}
//删除日志
if (ISLOGIN === true && $action == 'dellog') {
	include getViews ('header');
	include getViews ('write');
	include getViews ('footer');
}
//发表评论
if ($action == 'addcom') {
	require_once (EMLOG_ROOT . '/model/class.comment.php');
	$emComment = new emComment ($DB);
	
	$comment = isset ($_POST ['comment']) ? addslashes (trim ($_POST ['comment'])) : '';
	$commail = isset ($_POST ['commail']) ? addslashes (trim ($_POST ['commail'])) : '';
	$comurl = isset ($_POST ['comurl']) ? addslashes (trim ($_POST ['comurl'])) : '';
	$comname = isset ($_POST ['comname']) ? addslashes (trim ($_POST ['comname'])) : '';
	$imgcode = strtoupper (trim (isset ($_POST ['imgcode']) ? $_POST ['imgcode'] : ''));
	$gid = isset ($_GET ['gid']) ? intval ($_GET ['gid']) : - 1;
	
	$ret = $emComment->addComment ($comname, $comment, $commail, $comurl, $imgcode, $comment_code, $ischkcomment, $localdate, $gid);
	
	if ($ret === 0) {
		$CACHE->mc_sta ();
		$CACHE->mc_user ();
		$CACHE->mc_comment ();
		emMsg ('评论发表成功', BLOG_URL . "?post=$gid#comment", true);
	} elseif ($ret === 1) {
		$CACHE->mc_sta ();
		$CACHE->mc_user ();
		emMsg ('评论发表成功，请等待管理员审核', BLOG_URL . "?post=$gid");
	}
}
//最新评论
if ($action == 'com') {
	include getViews ('header');
	include getViews ('comment');
	include getViews ('footer');
}
//删除评论
if ($action == 'delcom') {
	include getViews ('header');
	include getViews ('comment');
	include getViews ('footer');
}
//审核评论
if ($action == 'showcom') {
	include getViews ('header');
	include getViews ('comment');
	include getViews ('footer');
}
//屏蔽评论
if ($action == 'hidecom') {
	include getViews ('header');
	include getViews ('comment');
	include getViews ('footer');
}
//回复评论
if ($action == 'replaycom') {
	include getViews ('header');
	include getViews ('comment');
	include getViews ('footer');
}
//显示碎语
if ($action == 'tw') {
	$page = isset ($_GET ['page']) ? intval ($_GET ['page']) : 1;
	if ($page) {
		$start_limit = ($page - 1) * $index_twnum;
		$id = ($page - 1) * $index_twnum;
	} else {
		$start_limit = 0;
		$page = 1;
		$id = 0;
	}
	$sql = " SELECT * FROM " . DB_PREFIX . "twitter ORDER BY id DESC  LIMIT $start_limit, $index_twnum";
	$twnum = $sta_cache ['twnum'];
	$pageurl = './?action=tw&page';
	$query = $DB->query ($sql);
	while ($row = $DB->fetch_array ($query)) {
		$row ['date'] = smartyDate ($row ['date']);
		$row ['content'] = htmlspecialchars (trim ($row ['content']));
		$tws [] = $row;
	}
	$page_url = pagination ($twnum, $index_twnum, $page, $pageurl);
	
	include getViews ('header');
	include getViews ('twitter');
	include getViews ('footer');

}
//写碎语页
if ($action == 'writet') {
	wap_header ('Twitter');
	echo "<p>内容:<br /><input name=\"tw\" type=\"text\"  format=\"M*m\"/></p>\n";
	echo "<p><anchor title=\"submit\">提交\n";
	echo "<go href=\"./?action=add_tw\" method=\"post\">\n";
	echo "<postfield name=\"tw\" value=\"$(tw)\" />\n";
	echo "<postfield name=\"do\" value=\"dowaplogin\" />\n";
	echo "</go></anchor>\n";
	echo "</p>\n";
	echo "<p><a href=\"?tem=$temp\">返回主页</a></p>\n";
	wap_footer ();
}
//新增碎语
if ($action == 'writet') {
	$content = isset ($_POST ['tw']) ? addslashes ($_POST ['tw']) : '';
	if (! empty ($content)) {
		$query = $DB->query ("INSERT INTO " . DB_PREFIX . "twitter (content,date) VALUES('$content','$localdate')");
		$CACHE->mc_twitter ();
		$CACHE->mc_sta ();
		header ("Location: ?action=twitter&amp;tem=$time");
	}
}
//删除碎语
if (ROLE == 'admin' && $action == 'del_tw') {
	$twid = isset ($_GET ['id']) ? intval ($_GET ['id']) : '';
	$query = $DB->query ("DELETE FROM " . DB_PREFIX . "twitter WHERE id=$twid");
	$CACHE->mc_twitter ();
	$CACHE->mc_sta ();
	header ("Location: ?action=twitter");
}
if ($action == 'login') {
	$login_code == 'y' ? $ckcode = "<span>验证码</span>
    <div class=\"val\"><input name=\"imgcode\" id=\"imgcode\" type=\"text\" />
    <img src=\"../lib/checkcode.php\" align=\"absmiddle\"></div>" : $ckcode = '';
	include getViews ('header');
	include getViews ('login');
	include getViews ('footer');
}
if ($action == 'auth') {
	session_start ();
	$username = addslashes(trim($_POST ['user']));
	$password = addslashes(trim($_POST ['pw']));
	$img_code = ($login_code == 'y' && isset ($_POST ['imgcode'])) ? addslashes (trim (strtoupper ($_POST ['imgcode']))) : '';
	$ispersis = true;
	if (checkUser ($username, $password, $img_code, $login_code) === true) {
		setAuthCookie ($username, $ispersis);
		header ("Location: ./");
	} else {
		header ("Location: ?action=login");
	}
}
if ($action == 'logout') {
	setcookie (AUTH_COOKIE_NAME, ' ', time () - 31536000, '/');
	header ("Location: ./");
}
//验证日志密码
function authPassword($pwd, $pwd2, $blogid) {
	if ($pwd !== $pwd2) {
		wap_header ('输入日志访问密码');
		echo "<p>密码:<input name=\"pw\" type=\"password\"  format=\"M*m\"/></p>\n";
		echo "<p><anchor title=\"submit\">进入..\n";
		echo "<go href=\"./?action=dis&amp;id=" . $blogid . "\" method=\"post\">\n";
		echo "<postfield name=\"pw\" value=\"$(pw)\" />\n";
		echo "<postfield name=\"do\" value=\"\" />\n";
		echo "</go></anchor>\n";
		echo "</p>\n";
		echo "<p><a href=\"./?action=logs\">返回日志列表</a></p>\n";
		wap_footer ();
		exit ();
	}
}
?>