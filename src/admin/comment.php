<?php
/**
 * 评论管理
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.2.0
 * $Id$
 */

require_once('globals.php');
require_once(EMLOG_ROOT.'/model/C_comment.php');

$emComment = new emComment($DB);

//加载评论管理页面
if($action == '')
{
	$blogId = isset($_GET['gid']) ? intval($_GET['gid']) : null;
	$hide = isset($_GET['hide']) ? $_GET['hide'] : '';
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

	$addUrl_1 = $blogId ? "gid={$blogId}&" : '';
	$addUrl_2 = $hide ? "hide=$hide&" : '';
	$addUrl = $addUrl_1.$addUrl_2;

	$comment = $emComment->getComments(1, $blogId, $hide, $page);
	$cmnum = $emComment->getCommentNum($blogId, $hide);
	$hideCommNum = $emComment->getCommentNum($blogId, 'y');
	$pageurl =  pagination($cmnum, ADMIN_PERPAGE_NUM, $page, "comment.php?{$addUrl}page");

	include getViews('header');
	require_once(getViews('comment'));
	include getViews('footer');
	cleanPage();
}
//操作评论
if($action== 'admin_all_coms')
{
	$operate = isset($_POST['operate']) ? $_POST['operate'] : '';
	$comments = isset($_POST['com']) ? $_POST['com'] : '';

	if($operate == '')
	{
		header("Location: ./comment.php?error_b=true");
		exit;
	}
	if($comments == '')
	{
		header("Location: ./comment.php?error_a=true");
		exit;
	}
	if($operate == 'del')
	{
		$emComment->batchComment('delcom', $comments);
		$CACHE->mc_sta();
		$CACHE->mc_user();
		$CACHE->mc_comment();
		header("Location: ./comment.php?active_del=true");
	}
	if($operate == 'hide')
	{
		$emComment->batchComment('hidecom', $comments);
		$CACHE->mc_sta();
		$CACHE->mc_user();
		$CACHE->mc_comment();
		header("Location: ./comment.php?active_hide=true");
	}
	if($operate == 'pub')
	{
		$emComment->batchComment('showcom', $comments);
		$CACHE->mc_sta();
		$CACHE->mc_user();
		$CACHE->mc_comment();
		header("Location: ./comment.php?active_show=true");
	}
}
//回复评论
if ($action== 'reply_comment')
{
	include getViews('header');
	$commentId = isset($_GET['cid']) ? intval($_GET['cid']) : '';
	$commentArray = $emComment->getOneComment($commentId);
	extract($commentArray);

	require_once(getViews('comment_reply'));
	include getViews('footer');cleanPage();
}
if($action=='doreply')
{
	$flg = isset($_GET['flg']) ? intval($_GET['flg']) : 0;
	$reply = isset($_POST['reply']) ? addslashes($_POST['reply']) : '';
	$commentId = isset($_REQUEST['cid']) ? intval($_REQUEST['cid']) : '';

	if(!$flg)
	{
		$emComment->replyComment($commentId, $reply);
		$CACHE->mc_comment();
		header("Location: ./comment.php?active_rep=true");
	}else{
		$reply = isset($_POST["reply$commentId"]) ? addslashes($_POST["reply$commentId"]) : '';
		$emComment->replyComment($commentId, $reply);
		$CACHE->mc_comment();
		echo "<span><b>博主回复</b>：$reply</span>";
	}
}

?>