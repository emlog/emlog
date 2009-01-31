<?php
/**
 * 评论管理
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-3.0.1
 * $Id$
 */

require_once('./globals.php');
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

	$comment = $emComment->getComment($blogId, $hide, $page);
	$num = $emComment->getCommentNum($blogId, $hide);
	$hideCommNum = $emComment->getCommentNum($blogId, 'y');
	$pageurl =  pagination($num,15,$page,"comment.php?{$addUrl}page");

	include getViews('header');
	require_once(getViews('comment'));
	include getViews('footer');
	cleanPage();
}

//批量操作评论
if($action== 'admin_all_coms')
{
	$doWhat = isset($_POST['modall']) ? $_POST['modall'] : '';
	$comments = isset($_POST['com']) ? $_POST['com'] : '';

	if($doWhat == '')
	{
		header("Location: ./comment.php?error_b=true");
		exit;
	}
	if($comments == '')
	{
		header("Location: ./comment.php?error_a=true");
		exit;
	}
	//删除
	if($doWhat == 'delcom')
	{
		$emComment->batchComment('delcom', $comments);
		$CACHE->mc_sta();
		$CACHE->mc_comment();
		header("Location: ./comment.php?active_del=true");
	}
	//屏蔽
	if($doWhat == 'hidecom')
	{
		$emComment->batchComment('hidecom', $comments);
		$CACHE->mc_sta();
		$CACHE->mc_comment();
		header("Location: ./comment.php?active_hide=true");
	}
	//审核
	if($doWhat == 'showcom')
	{
		$emComment->batchComment('showcom', $comments);
		$CACHE->mc_sta();
		$CACHE->mc_comment();
		header("Location: ./comment.php?active_show=true");
	}
}
//删除评论
if ($action== 'del_comment')
{
	$commentId = isset($_GET['commentid']) ? intval($_GET['commentid']) : '';
	$emComment->delComment($commentId);
	$CACHE->mc_sta();
	$CACHE->mc_comment();
	header("Location: ./comment.php?active_del=true");
}
//屏蔽评论
if($action=='hide_comment')
{
	$commentId = isset($_GET['cid']) ? intval($_GET['cid']) : '';
	$emComment->hideComment($commentId);
	$CACHE->mc_sta();
	$CACHE->mc_comment();
	header("Location: ./comment.php?active_hide=true");
}
//审核评论
if($action=='show_comment')
{
	$commentId = isset($_GET['cid']) ? intval($_GET['cid']) : '';
	$emComment->showComment($commentId);
	$CACHE->mc_sta();
	$CACHE->mc_comment();
	header("Location: ./comment.php?active_show=true");
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