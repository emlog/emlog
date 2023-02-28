<?php
/**
 * comments
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

$Comment_Model = new Comment_Model();

if (!$action) {
	$blogId = isset($_GET['gid']) ? (int)$_GET['gid'] : null;
	$hide = isset($_GET['hide']) ? addslashes($_GET['hide']) : '';
	$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

	$addUrl_1 = $blogId ? "gid=$blogId&" : '';
	$addUrl_2 = $hide ? "hide=$hide&" : '';
	$addUrl = $addUrl_1 . $addUrl_2;

	$comment = $Comment_Model->getCommentsForAdmin($blogId, $hide, $page);
	$cmnum = $Comment_Model->getCommentNum($blogId, $hide);
	$hideCommNum = $Comment_Model->getCommentNum($blogId, 'y');
	$pageurl = pagination($cmnum, Option::get('admin_perpage_num'), $page, "comment.php?{$addUrl}page=");

	include View::getAdmView('header');
	require_once(View::getAdmView('comment'));
	include View::getAdmView('footer');
	View::output();
}

if ($action === 'delbyip') {
	LoginAuth::checkToken();
	if (!User::haveEditPermission()) {
		emMsg('权限不足！', './');
	}
	$ip = $_GET['ip'] ? addslashes($_GET['ip']) : '';
	$Comment_Model->delCommentByIp($ip);
	$CACHE->updateCache(array('sta', 'comment'));
	emDirect("./comment.php?active_del=1");
}

if ($action === 'batch_operation') {
	$operate = isset($_POST['operate']) ? $_POST['operate'] : '';
	$comments = isset($_POST['com']) ? array_map('intval', $_POST['com']) : [];

	if (empty($comments)) {
		emDirect("./comment.php?error_a=1");
	}

	switch ($operate) {
		case 'del' :
			$Comment_Model->batchComment('delcom', $comments);
			$CACHE->updateCache(array('sta', 'comment'));
			emDirect("./comment.php?active_del=1");
			break;
		case 'hide':
			$Comment_Model->batchComment('hidecom', $comments);
			$CACHE->updateCache(array('sta', 'comment'));
			emDirect("./comment.php?active_hide=1");
			break;
		case 'pub':
			$Comment_Model->batchComment('showcom', $comments);
			$CACHE->updateCache(array('sta', 'comment'));
			emDirect("./comment.php?active_show=1");
			break;
		case 'top':
			$Comment_Model->batchComment('top', $comments);
			emDirect("./comment.php?active_top=1");
			break;
		case 'untop':
			$Comment_Model->batchComment('untop', $comments);
			emDirect("./comment.php?active_untop=1");
			break;
		default:
			emDirect("./comment.php?error_b=1");
	}
}

if ($action === 'doreply') {
	$reply = isset($_POST['reply']) ? trim(addslashes($_POST['reply'])) : '';
	$commentId = isset($_POST['cid']) ? (int)$_POST['cid'] : '';
	$blogId = isset($_POST['gid']) ? (int)$_POST['gid'] : '';
	$hide = isset($_POST['hide']) ? addslashes($_POST['hide']) : 'n';

	if (empty($reply)) {
		emDirect("./comment.php?error_c=1");
	}

	//回复一条待审核的评论，视为要将其公开（包括回复内容）
	if ($hide == 'y') {
		$Comment_Model->showComment($commentId);
		$hide = 'n';
	}

	$Comment_Model->replyComment($blogId, $commentId, $reply, $hide);
	$CACHE->updateCache('comment');
	$CACHE->updateCache('sta');
	doAction('comment_reply', $commentId, $reply);
	emDirect("./comment.php?active_rep=1");
}
