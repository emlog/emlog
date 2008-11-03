<?php
/**
 * 评论管理
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.7.0
 * $Id$
 */

require_once('./globals.php');
require_once(EMLOG_ROOT.'/model/C_comment.php');

$emComment = new emComment($DB);

//加载评论管理页面
if($action == '')
{
	$blogId = isset($_GET['gid']) ? intval($_GET['gid']) : null;
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

	$addUrl = $blogId ? "gid={$blogId}&" : '';
	$comment = $emComment->getComment($blogId, $page);
	$num = $emComment->getCommentNum($blogId);
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
		formMsg('请选择一个要执行的操作','./comment.php',0);
	}
	if($comments == '')
	{
		formMsg('请选择要执行操作的评论','./comment.php',0);
	}
	//删除
	if($doWhat == 'delcom')
	{
		$emComment->batchComment('delcom', $comments);
		$CACHE->mc_sta('sta');
		$CACHE->mc_comment('comments');
		formMsg('评论删除成功','./comment.php',1);
	}
	//屏蔽
	if($doWhat == 'hidecom')
	{
		$emComment->batchComment('hidecom', $comments);
		$CACHE->mc_sta('sta');
		$CACHE->mc_comment('comments');
		formMsg('屏蔽评论成功','./comment.php',1);
	}
	//审核
	if($doWhat == 'showcom')
	{
		$emComment->batchComment('showcom', $comments);
		$CACHE->mc_sta('sta');
		$CACHE->mc_comment('comments');
		formMsg('审核评论成功','./comment.php',1);
	}
}
//删除评论
if ($action== 'del_comment')
{
	$commentId = isset($_GET['commentid']) ? intval($_GET['commentid']) : '';
	$emComment->delComment($commentId);
	$CACHE->mc_sta('sta');
	$CACHE->mc_comment('comments');
	formMsg('评论删除成功','./comment.php',1);
}
//屏蔽评论
if($action=='hide_comment')
{
	$commentId = isset($_GET['cid']) ? intval($_GET['cid']) : '';
	$emComment->hideComment($commentId);
	$CACHE->mc_sta('sta');
	$CACHE->mc_comment('comments');
	formMsg('评论屏蔽成功','./comment.php',1);
}
//审核评论
if($action=='show_comment')
{
	$commentId = isset($_GET['cid']) ? intval($_GET['cid']) : '';
	$emComment->showComment($commentId);
	$CACHE->mc_sta('sta');
	$CACHE->mc_comment('comments');
	formMsg('评论审核成功','./comment.php',1);
}
//回复评论
if ($action== 'reply_comment')
{
	include getViews('header');
	$cid = isset($_GET['cid']) ? intval($_GET['cid']) : '';
	$commentArray = $emComment->getOneComment($cid);
	$comment = htmlspecialchars(trim($commentArray['comment']));
	$reply = htmlspecialchars(trim($commentArray['reply']));
	$name = trim($commentArray['poster']);
	$date = date("Y-m-d H:i",$commentArray['date']);

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
		$CACHE->mc_comment('comments');
		formMsg("评论回复成功","./comment.php",1);
	}else{
		$reply = isset($_POST["reply$cid"]) ? addslashes($_POST["reply$cid"]) : '';
		$emComment->replyComment($commentId, $reply);
		$CACHE->mc_comment('comments');
		echo "<span><b>博主回复</b>：$reply</span>";
	}
}

?>