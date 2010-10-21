<?php
/**
 * 评论管理
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

require_once 'globals.php';

$Comment_Model = new Comment_Model();

if($action == '')
{
	$blogId = isset($_GET['gid']) ? intval($_GET['gid']) : null;
	$hide = isset($_GET['hide']) ? addslashes($_GET['hide']) : '';
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

	$addUrl_1 = $blogId ? "gid={$blogId}&" : '';
	$addUrl_2 = $hide ? "hide=$hide&" : '';
	$addUrl = $addUrl_1.$addUrl_2;

	$comment = $Comment_Model->getComments(1, $blogId, $hide, $page);
	$cmnum = $Comment_Model->getCommentNum($blogId, $hide);
	$hideCommNum = $Comment_Model->getCommentNum($blogId, 'y');
	$pageurl =  pagination($cmnum, Option::get('admin_perpage_num'), $page, "comment.php?{$addUrl}page");

	include View::getView('header');
	require_once(View::getView('comment'));
	include View::getView('footer');
	View::output();
}
if ($action== 'del')
{
	$id = isset($_GET['id']) ? intval($_GET['id']) : '';
	$Comment_Model->delComment($id);
	$CACHE->updateCache(array('sta','comment'));
	header("Location: ./comment.php?active_del=true");
}
if($action=='hide')
{
	$id = isset($_GET['id']) ? intval($_GET['id']) : '';
	$Comment_Model->hideComment($id);
	$CACHE->updateCache(array('sta','comment'));
	header("Location: ./comment.php?active_hide=true");
}
if($action=='show')
{
	$id = isset($_GET['id']) ? intval($_GET['id']) : '';
	$Comment_Model->showComment($id);
	$CACHE->updateCache(array('sta','comment'));
	header("Location: ./comment.php?active_show=true");
}
if($action== 'admin_all_coms')
{
	$operate = isset($_POST['operate']) ? $_POST['operate'] : '';
	$comments = isset($_POST['com']) ? array_map('intval', $_POST['com']) : array();

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
		$Comment_Model->batchComment('delcom', $comments);
		$CACHE->updateCache(array('sta','comment'));
		header("Location: ./comment.php?active_del=true");
	}
	if($operate == 'hide')
	{
		$Comment_Model->batchComment('hidecom', $comments);
		$CACHE->updateCache(array('sta','comment'));
		header("Location: ./comment.php?active_hide=true");
	}
	if($operate == 'pub')
	{
		$Comment_Model->batchComment('showcom', $comments);
		$CACHE->updateCache(array('sta', 'comment'));
		header("Location: ./comment.php?active_show=true");
	}
}
if ($action== 'reply_comment')
{
	include View::getView('header');
	$commentId = isset($_GET['cid']) ? intval($_GET['cid']) : '';
	$commentArray = $Comment_Model->getOneComment($commentId);
	extract($commentArray);

	require_once(View::getView('comment_reply'));
	include View::getView('footer');
	View::output();
}
if($action=='doreply')
{
	$flg = isset($_GET['flg']) ? intval($_GET['flg']) : 0;
	$reply = isset($_POST['reply']) ? addslashes($_POST['reply']) : '';
	$commentId = isset($_REQUEST['cid']) ? intval($_REQUEST['cid']) : '';

	if(!$flg)
	{
	    if(isset($_POST['pub_it'])) {
	        $Comment_Model->showComment($commentId);
	        $CACHE->updateCache('sta');
	    }
		$Comment_Model->replyComment($commentId, $reply);
		$CACHE->updateCache('comment');
		doAction('comment_reply', $commentId, $reply);
		header("Location: ./comment.php?active_rep=true");
	}else{
		$reply = isset($_POST["reply$commentId"]) ? addslashes($_POST["reply$commentId"]) : '';
		$Comment_Model->replyComment($commentId, $reply);
		$CACHE->updateCache('comment');
		doAction('comment_reply', $commentId, $reply);
		echo "<span>博主回复：$reply</span>";
	}
}
