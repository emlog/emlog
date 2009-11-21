<?php
/**
 * mobile 版本
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.4.0
 * $Id:  526 2008-07-05 15:21:03Z emloog $
 */

require_once ('../common.php');

define ('TEMPLATE_PATH', EMLOG_ROOT . '/m/view/');
define ('ADMIN_PERPAGE_NUM', 5);

$isgzipenable = 'n';//手机浏览关闭gzip压缩
$index_lognum = 5;
$index_twnum = 5;
$logid = isset ($_GET ['post']) ? intval ($_GET ['post']) : '';
$blogname = $options_cache ['blogname'];
$blogdes = $options_cache ['bloginfo'];

//首页
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
//日志
if (!empty ($logid)) {
	require_once (EMLOG_ROOT . '/model/class.blog.php');
	require_once (EMLOG_ROOT . '/model/class.comment.php');
	
	$emBlog = new emBlog ($DB);
	$emComment = new emComment ($DB);
	
	$logData = $emBlog->getOneLogForHome ($logid);
	if ($logData === false) {
		mMsg ('不存在该条目', './');
	}
	extract ($logData);
	if (! empty ($password)) {
		$postpwd = isset ($_POST ['logpwd']) ? addslashes (trim ($_POST ['logpwd'])) : '';
		$cookiepwd = isset ($_COOKIE ['em_logpwd_' . $logid]) ? addslashes (trim ($_COOKIE ['em_logpwd_' . $logid])) : '';
		authPassword ($postpwd, $cookiepwd, $password, $logid);
	}
	//comments
	$cheackimg = $comment_code == 'y' ? "<img src=\"".BLOG_URL."lib/checkcode.php\" /><input name=\"imgcode\" type=\"text\" />" : '';
	$comments = $emComment->getComments (0, $logid, 'n');
	
	$emBlog->updateViewCount ($logid);
	include getViews ('header');
	include getViews ('single');
	include getViews ('footer');
}
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
		$date = '';
	}
	include getViews ('header');
	include getViews ('write');
	include getViews ('footer');
}
if (ISLOGIN === true && $action == 'savelog') {
	require_once(EMLOG_ROOT.'/model/class.blog.php');
	require_once(EMLOG_ROOT.'/model/class.tag.php');

	$emBlog = new emBlog($DB);
	$emTag = new emTag($DB);

	$title = isset($_POST['title']) ? addslashes(trim($_POST['title'])) : '';
	$sort = isset($_POST['sort']) ? intval($_POST['sort']) : '';
	$content = isset($_POST['content']) ? addslashes(trim($_POST['content'])) : '';
	$tagstring = isset($_POST['tag']) ? addslashes(trim($_POST['tag'])) : '';
	$blogid = isset($_POST['gid']) ? intval(trim($_POST['gid'])) : -1;
	$date = isset($_POST['date']) ? addslashes($_POST['date']) : '';
	$author = isset($_POST['author']) ? intval(trim($_POST['author'])) : UID;
	$postTime = empty($date) ? $emBlog->postDate($timezone) : $date;

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
if (ISLOGIN === true && $action == 'dellog') {
	include getViews ('header');
	include getViews ('write');
	include getViews ('footer');
}
//评论
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
		header("Location: ./?post=$gid");
	} elseif ($ret === 1) {
		$CACHE->mc_sta ();
		$CACHE->mc_user ();
		mMsg ('评论发表成功，请等待管理员审核', "./?post=$gid");
	}
}
if ($action == 'com') {
	if(ISLOGIN === true)
	{
		$hide = '';
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	
		require_once (EMLOG_ROOT . '/model/class.comment.php');
		$emComment = new emComment ($DB);
	
		$comment = $emComment->getComments(1, null, $hide, $page);
		$cmnum = $emComment->getCommentNum(null, $hide);
		$pageurl =  pagination($cmnum, 5, $page, "./?action=com&page");
	}else{
		$comment = $com_cache;
		$pageurl = '';
	}
	include getViews ('header');
	include getViews ('comment');
	include getViews ('footer');
}
if (ISLOGIN === true && $action == 'delcom') {
	require_once (EMLOG_ROOT . '/model/class.comment.php');
	$emComment = new emComment ($DB);
	$id = isset($_GET['id']) ? intval($_GET['id']) : '';
	$emComment->delComment($id);
	$CACHE->mc_sta();
	$CACHE->mc_user();
	$CACHE->mc_comment();
	header("Location: ./?action=com");
}
if (ISLOGIN === true && $action == 'showcom') {
	require_once (EMLOG_ROOT . '/model/class.comment.php');
	$emComment = new emComment ($DB);
	$id = isset($_GET['id']) ? intval($_GET['id']) : '';
	$emComment->showComment($id);
	$CACHE->mc_sta();
	$CACHE->mc_user();
	$CACHE->mc_comment();
	header("Location: ./?action=com");
}
if (ISLOGIN === true && $action == 'hidecom') {
	require_once (EMLOG_ROOT . '/model/class.comment.php');
	$emComment = new emComment ($DB);
	$id = isset($_GET['id']) ? intval($_GET['id']) : '';
	$emComment->hideComment($id);
	$CACHE->mc_sta();
	$CACHE->mc_user();
	$CACHE->mc_comment();
	header("Location: ./?action=com");
}
if (ISLOGIN === true && $action == 'reply') {
	require_once (EMLOG_ROOT . '/model/class.comment.php');
	$emComment = new emComment ($DB);
	$id = isset($_GET['id']) ? intval($_GET['id']) : '';
	$commentArray = $emComment->getOneComment($id);
	extract($commentArray);
	include getViews('header');
	include getViews('reply');
	include getViews('footer');
}
if (ISLOGIN === true && $action == 'dorep') {
	require_once (EMLOG_ROOT . '/model/class.comment.php');
	$emComment = new emComment ($DB);
	$reply = isset($_POST['reply']) ? addslashes($_POST['reply']) : '';
	$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : '';
	$emComment->replyComment($id, $reply);
	$CACHE->mc_comment();
	header("Location: ./?action=com");
}
//碎语
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
if (ISLOGIN === true && $action == 't') {
	$t = isset ($_POST ['t']) ? addslashes ($_POST ['t']) : '';
	if (! empty ($t)) {
		$query = $DB->query ("INSERT INTO " . DB_PREFIX . "twitter (content,author,date) VALUES('$t',".UID.",'$localdate')");
		$CACHE->mc_sta ();
		header ("Location: ./?action=tw");
	}else{
		header ("Location: ./");
	}
}
if (ISLOGIN === true && $action == 'delt') {
	$id = isset ($_GET ['id']) ? intval ($_GET ['id']) : '';
	$author = ROLE == 'admin' ? '' : 'and author='.UID;
	$query = $DB->query ("DELETE FROM " . DB_PREFIX . "twitter WHERE id=$id $author");
	$CACHE->mc_sta ();
	header ("Location: ./?action=tw");
}
if ($action == 'login') {
	$login_code == 'y' ? $ckcode = "<span>验证码</span>
    <div class=\"val\"><input name=\"imgcode\" id=\"imgcode\" type=\"text\" />
    <img src=\"".BLOG_URL."lib/checkcode.php\" /></div>" : $ckcode = '';
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
		header ("Location: ?tem=".time());
	} else {
		header ("Location: ?action=login");
	}
}
if ($action == 'logout') {
	setcookie (AUTH_COOKIE_NAME, ' ', time () - 31536000, '/');
	header ("Location: ?tem=".time());
}
function mMsg($msg, $url){
	global $blogname,$blogdes;
	include getViews ('header');
	include getViews ('msg');
	include getViews ('footer');
}
function authPassword($postPwd, $cookiePwd, $logPwd, $logid) {
	global $blogname,$blogdes;
	$pwd = $cookiePwd ? $cookiePwd : $postPwd;
	if($pwd !== addslashes($logPwd)){
		include getViews ('header');
		include getViews ('logauth');
		include getViews ('footer');
		if($cookiePwd)
		{
			setcookie('em_logpwd_'.$logid, ' ', time() - 31536000);
		}
		exit;
	}else {
		setcookie('em_logpwd_'.$logid, $logPwd);
	}
}
?>