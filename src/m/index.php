<?php
/**
 * Mobile Version
 *
 * @copyright (c) Emlog All Rights Reserved
 */

require_once '../init.php';

/*vot*/ load_language('m');//mobile language

define ('TEMPLATE_PATH', EMLOG_ROOT . '/m/view/');

$isgzipenable = 'n'; //Disable gzip compression for Mobile browsers
$index_lognum = 5;
$site_title = Option::get('blogname');

$logid = isset ($_GET['post']) ? intval ($_GET['post']) : '';
$action = isset($_GET['action']) ? addslashes($_GET['action']) : '';

if (Option::get('ismobile') == 'n') {
	emMsg($lang['mobile_disabled'], BLOG_URL);
}

$navi_cache = $CACHE->readCache('navi');
$user_cache = $CACHE->readCache('user');

// Home
if (empty ($action) && empty ($logid)) {
	$Log_Model = new Log_Model();
	$page = isset($_GET['page']) ? abs(intval ($_GET['page'])) : 1;
	$sqlSegment = "ORDER BY top DESC ,date DESC";
	$sta_cache = $CACHE->readCache('sta');
	$lognum = $sta_cache['lognum'];
	$pageurl = './?page=';
	$logs = $Log_Model->getLogsForHome ($sqlSegment, $page, $index_lognum);
	$page_url = pagination($lognum, $index_lognum, $page, $pageurl);

	include View::getView('header');
	include View::getView('log');
	include View::getView('footer');
	View::output();
}
// Post
if (!empty ($logid)) {
	$Log_Model = new Log_Model();
	$Comment_Model = new Comment_Model();

	$logData = $Log_Model->getOneLogForHome($logid);
	if ($logData === false) {
		mMsg ($lang['entry_not_exists'], './');
	}
	extract($logData);

    $site_title = $log_title;
    if (!empty($password)) {
		$postpwd = isset($_POST['logpwd']) ? addslashes(trim ($_POST['logpwd'])) : '';
		$cookiepwd = isset($_COOKIE ['em_logpwd_' . $logid]) ? addslashes(trim($_COOKIE ['em_logpwd_' . $logid])) : '';
		authPassword ($postpwd, $cookiepwd, $password, $logid);
	}
	// comments
	$commentPage = isset($_GET['comment-page']) ? intval($_GET['comment-page']) : 1;
	$verifyCode = ISLOGIN == false && Option::get('comment_code') == 'y' ? "<img src=\"../include/lib/checkcode.php\" /><br /><input name=\"imgcode\" type=\"text\" />" : '';
	$comments = $Comment_Model->getComments(2, $logid, 'n', $commentPage);
	extract($comments);

	$Log_Model->updateViewCount($logid);
	include View::getView('header');
	include View::getView('single');
	include View::getView('footer');
	View::output();
}
if (ISLOGIN === true && $action == 'write') {
	$logid = isset($_GET['id']) ? intval($_GET['id']) : '';
	$Sort_Model = new Sort_Model();
	$sorts = $Sort_Model->getSorts();
	if ($logid) {
		$Log_Model = new Log_Model();
		$Tag_Model = new Tag_Model();

		$blogData = $Log_Model->getOneLogForAdmin($logid);
		extract($blogData);
		$tags = array();
		foreach ($Tag_Model->getTag($logid) as $val) {
			$tags[] = $val['tagname'];
		}
		$tagStr = implode(',', $tags);
	}else {
		$title = '';
		$sortid = -1;
		$content = '';
		$excerpt = '';
		$tagStr = '';
		$logid = -1;
		$author = UID;
		$date = '';
	}
	include View::getView('header');
	include View::getView('write');
	include View::getView('footer');
	View::output();
}
if (ISLOGIN === true && $action == 'savelog') {
	$Log_Model = new Log_Model();
	$Tag_Model = new Tag_Model();

    LoginAuth::checkToken();

	$title = isset($_POST['title']) ? addslashes(trim($_POST['title'])) : '';
	$sort = isset($_POST['sort']) ? intval($_POST['sort']) : '';
	$content = isset($_POST['content']) ? nl2br(addslashes(trim($_POST['content']))) : '';
	$excerpt = isset($_POST['excerpt']) ? addslashes(trim($_POST['excerpt'])) : '';
	$tagstring = isset($_POST['tag']) ? addslashes(trim($_POST['tag'])) : '';
	$blogid = isset($_POST['gid']) ? intval(trim($_POST['gid'])) : -1;
	$date = isset($_POST['date']) ? addslashes($_POST['date']) : '';
	$author = isset($_POST['author']) ? intval(trim($_POST['author'])) : UID;
	$postTime = $Log_Model->postDate(Option::get('timezone'), $date);	

	$logData = array('title' => $title,
		'content' => $content,
		'excerpt' => $excerpt,
		'author' => $author,
		'sortid' => $sort,
		'date' => $postTime,
		'allow_remark' => 'y',
		'hide' => 'n',
		'password' => ''
		);

	if ($blogid > 0) {
		$Log_Model->updateLog($logData, $blogid);
		$Tag_Model->updateTag($tagstring, $blogid);
	}else {
		$blogid = $Log_Model->addlog($logData);
		$Tag_Model->addTag($tagstring, $blogid);
	}
	$CACHE->updateCache();
	emDirect("./");
}
// Add Comment
if ($action == 'addcom') {
	$Comment_Model = new Comment_Model();

	$name = isset($_POST['comname']) ? addslashes(trim($_POST['comname'])) : '';
    $content = isset($_POST['comment']) ? addslashes(trim($_POST['comment'])) : '';
    $mail = isset($_POST['commail']) ? addslashes(trim($_POST['commail'])) : '';
    $url = isset($_POST['comurl']) ? addslashes(trim($_POST['comurl'])) : '';
    $imgcode = isset($_POST['imgcode']) ? strtoupper(trim($_POST['imgcode'])) : '';
    $blogId = isset($_GET['gid']) ? intval($_GET['gid']) : - 1;
    $pid = isset($_GET['pid']) ? intval($_GET['pid']) : 0;

    $targetBlogUrl = './?post=' . $blogId;

    if (ISLOGIN === true) {
		$name = addslashes($user_cache[UID]['name_orig']);
       	$mail = addslashes($user_cache[UID]['mail']);
        $url = addslashes(BLOG_URL);
    }

	if ($url && strncasecmp($url,'http',4)) {
		$url = 'http://'.$url;
	}

    doAction('comment_post');

	if($Comment_Model->isLogCanComment($blogId) === false){
        mMsg($lang['comments_disabled'], $targetBlogUrl);
    } elseif ($Comment_Model->isCommentExist($blogId, $name, $content) === true){
        mMsg($lang['comment_allready_exists'], $targetBlogUrl);
    } elseif ($Comment_Model->isCommentTooFast() === true) {
		mMsg($lang['comment_too_fast'], $targetBlogUrl);
	} elseif (mb_strlen($name) > 20 || mb_strlen($name) == 0){
        mMsg($lang['comment_name_invalid'], $targetBlogUrl);
    } elseif ($mail != '' && !checkMail($mail)) {
        mMsg($lang['comment_email_invalid'], $targetBlogUrl);
    } elseif (ISLOGIN == false && $Comment_Model->isNameAndMailValid($name, $mail) === false){
        mMsg($lang['comment_admin_restricted'], $targetBlogUrl);
    } elseif (mb_strlen($content) == '' || mb_strlen($content) > 2000) {
        mMsg($lang['comment_invalid'], $targetBlogUrl);
    } elseif (ROLE == ROLE_VISITOR && Option::get('comment_needchinese') == 'y' && !preg_match('/[\x{4e00}-\x{9fa5}]/iu', $content)) {
		mMsg($lang['comment_chinese'], $targetBlogUrl);
	}elseif (ISLOGIN == false && Option::get('comment_code') == 'y' && session_start() && $imgcode != $_SESSION['code']) {
        mMsg($lang['comment_captcha_invalid'], $targetBlogUrl);
    } else {
		$DB = Database::getInstance();
        $ipaddr = getIp();
		$utctimestamp = time();

		if($pid != 0) {
			$comment = $Comment_Model->getOneComment($pid);
			$content = '@' . addslashes($comment['poster']) . ':' . $content;
		}

		$ischkcomment = Option::get('ischkcomment');
		$hide = ROLE == ROLE_VISITOR ? $ischkcomment : 'n';

		$sql = 'INSERT INTO '.DB_PREFIX."comment (date,poster,gid,comment,mail,url,hide,ip,pid)
				VALUES ('$utctimestamp','$name','$blogId','$content','$mail','$url','$hide','$ipaddr','$pid')";
		$ret = $DB->query($sql);
		$cid = $DB->insert_id();
		$CACHE = Cache::getInstance();

		if ($hide == 'n') {
			$DB->query('UPDATE '.DB_PREFIX."blog SET comnum = comnum + 1 WHERE gid='$blogId'");
			$CACHE->updateCache(array('sta', 'comment'));
            doAction('comment_saved', $cid);
            emDirect($targetBlogUrl);
		} else {
		    $CACHE->updateCache('sta');
		    doAction('comment_saved', $cid);
		    mMsg($lang['comment_posted_premod'], $targetBlogUrl);
		}
    }
}
if (ROLE === ROLE_ADMIN && $action == 'delcom') {
    LoginAuth::checkToken();
    $blogId = isset($_GET['gid']) ? intval($_GET['gid']) : - 1;
    $id = isset($_GET['id']) ? intval($_GET['id']) : '';

	$Comment_Model = new Comment_Model();
	$Comment_Model->delComment($id);
	$CACHE->updateCache(array('sta','comment'));
	emDirect('./?post=' . $blogId);
}
if ($action == 'reply') {
	$Comment_Model = new Comment_Model();
	$cid = isset($_GET['cid']) ? intval($_GET['cid']) : 0;
	$commentArray = $Comment_Model->getOneComment($cid);
	if(!$commentArray) {
		mMsg($lang['parameter_error'], './');
	}
	extract($commentArray);
	$verifyCode = ISLOGIN == false && Option::get('comment_code') == 'y' ? "<img src=\"../include/lib/checkcode.php\" /><br /><input name=\"imgcode\" type=\"text\" />" : '';
	include View::getView('header');
	include View::getView('reply');
	include View::getView('footer');
	View::output();
}
// Twitters
if ($action == 'tw' && Option::get('istwitter') == 'y') {
    $Twitter_Model = new Twitter_Model();
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $tws = $Twitter_Model->getTwitters($page);
    $twnum = $Twitter_Model->getTwitterNum();
    $pageurl =  pagination($twnum, Option::get('index_twnum'), $page, './?action=tw&page=');
    $site_title = $lang['twitter'];

	include View::getView('header');
	include View::getView('twitter');
	include View::getView('footer');
	View::output();
}
if (ROLE === ROLE_ADMIN && $action == 't') {
    LoginAuth::checkToken();
    $Twitter_Model = new Twitter_Model();

    $t = isset($_POST['t']) ? addslashes(trim($_POST['t'])) : '';
    $attach = isset($_FILES['img']) ? $_FILES['img'] : '';

    if ($attach['tmp_name'] && !$t) {
    	$t = $lang['image_share'];
    }

    if (!$t){
        emDirect("./?action=tw");
    }
    $tdata = array('content' => $Twitter_Model->formatTwitter($t),
            'author' => UID,
            'date' => time(),
    );

	if ($attach['tmp_name']) {
		$fileinfo = uploadFile($attach['name'], $attach['error'], $attach['tmp_name'], $attach['size'], array('jpg', 'jpeg','png'), false, false);
		$upfname = $fileinfo['file_path'];
        $size = @getimagesize($upfname);
		$w = $size[0];
		$h = $size[1];
		if ($w>150 || $h>120) {
			$uppath = Option::UPLOADFILE_PATH . gmdate('Ym') . '/';
			$thum = str_replace($uppath,$uppath.'thum-',$upfname);
			resizeImage($upfname, $thum, 120, 150);
			$upfname = $thum;
		}

		$tdata['img'] = str_replace('../', '', $upfname);
	}

    $Twitter_Model->addTwitter($tdata);
    $CACHE->updateCache(array('sta','newtw'));
    doAction('post_twitter', $t);
    emDirect("./?action=tw");
}
if (ROLE === ROLE_ADMIN && $action == 'delt') {
    LoginAuth::checkToken();
    $Twitter_Model = new Twitter_Model();
    $id = isset($_GET['id']) ? intval($_GET['id']) : '';
	$Twitter_Model->delTwitter($id);
	$CACHE->updateCache(array('sta','newtw'));
	emDirect("./?action=tw");
}
if ($action == 'login') {
	Option::get('login_code') == 'y' ? $ckcode = "<span>{$lang['verification_code']}</span>
    <div class=\"val\"><img src=\"../include/lib/checkcode.php\" /><br />
	<input name=\"imgcode\" id=\"imgcode\" type=\"text\" />
    </div>" : $ckcode = '';
	include View::getView('header');
	include View::getView('login');
	include View::getView('footer');
	View::output();
}
if ($action == 'auth') {
	session_start();
	$username = addslashes(trim($_POST['user']));
	$password = addslashes(trim($_POST['pw']));
	$img_code = (Option::get('login_code') == 'y' && isset ($_POST['imgcode'])) ? addslashes (trim (strtoupper ($_POST['imgcode']))) : '';
	$ispersis = true;
	if (LoginAuth::checkUser($username, $password, $img_code) === true) {
		loginAuth::setAuthCookie($username, $ispersis);
		emDirect('?tem=' . time());
	}else {
		emDirect("?action=login");
	}
}
if ($action == 'logout') {
	setcookie(AUTH_COOKIE_NAME, ' ', time () - 31536000, '/');
	emDirect('?tem=' . time());
}
function mMsg($msg, $url) {
	include View::getView('header');
	include View::getView('msg');
	include View::getView('footer');
	View::output();
}
function authPassword($postPwd, $cookiePwd, $logPwd, $logid) {
	$pwd = $cookiePwd ? $cookiePwd : $postPwd;
	if ($pwd !== addslashes($logPwd)) {
		include View::getView('header');
		include View::getView('logauth');
		include View::getView('footer');
		if ($cookiePwd) {
			setcookie('em_logpwd_' . $logid, ' ', time() - 31536000);
		}
		View::output();
	}else {
		setcookie('em_logpwd_' . $logid, $logPwd);
	}
}
