<?php
/**
 * 管理日志
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-3.0.1
 * $Id$
 */

require_once('./globals.php');
require_once(EMLOG_ROOT.'/model/C_blog.php');
require_once(EMLOG_ROOT.'/model/C_tag.php');
require_once(EMLOG_ROOT.'/model/C_sort.php');

$emBlog = new emBlog($DB);

//显示日志(草稿)管理页面
if($action == '')
{
	$emTag = new emTag($DB);
	$emSort = new emSort($DB);

	$pid = isset($_GET['pid']) ? $_GET['pid'] : '';
	$tag = isset($_GET['tag']) ? $_GET['tag'] : '';
	$sid = isset($_GET['sid']) ? intval($_GET['sid']) : '';
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

	$sortView = (isset($_GET['sortView']) && $_GET['sortView'] == 'ASC') ?  'DESC' : 'ASC';
	$sortComm = (isset($_GET['sortComm']) && $_GET['sortComm'] == 'ASC') ?  'DESC' : 'ASC';
	$sortDate = (isset($_GET['sortDate']) && $_GET['sortDate'] == 'DESC') ?  'ASC' : 'DESC';

	$sqlSegment = '';
	if($tag)
	{
		$blogIdStr = $emTag->getTagByName($tag);
		$sqlSegment = "and gid IN ($blogIdStr)";
	}elseif ($sid){
		$sqlSegment = "and sortid=$sid";
	}
	$sqlSegment .= ' ORDER BY ';
	if(isset($_GET['sortView']))
	{
		$sqlSegment .= "views $sortView";
	}elseif(isset($_GET['sortComm'])){
		$sqlSegment .= "comnum $sortComm";
	}elseif(isset($_GET['sortDate'])){
		$sqlSegment .= "date $sortDate";
	}else {
		$sqlSegment .= 'top DESC,date DESC';
	}

	$hide_state = $pid ? 'y' : 'n';
	if($pid == 'draft')
	{
		$hide_stae = 'y';
		$sorturl = '&pid=draft';
		$pwd = '草稿箱';
	}else{
		$hide_stae = 'n';
		$sorturl = '';
		$pwd = '日志管理';
	}

	$logNum = $emBlog->getLogNum($hide_state, $sqlSegment);
	$logs = $emBlog->getLog($sqlSegment, $hide_state, $page);
	$sorts = $emSort->getSorts();
	$tags = $emTag->getTag();

	$subPage = '';
	foreach ($_GET as $key=>$val)
	{
		$subPage .= $key != 'page' ? "&$key=$val" : '';
	}
	$pageurl =  pagination($logNum, 15, $page, "admin_log.php?{$subPage}&page");

	include getViews('header');
	require_once(getViews('admin_log'));
	include getViews('footer');cleanPage();
}

//批量操作日志
if($action == 'admin_all_log')
{
	$dowhat = isset($_POST['modall']) ? $_POST['modall'] : '';
	$pid = isset($_POST['pid']) ? $_POST['pid'] : '';
	$logs = isset($_POST['blog']) ? $_POST['blog'] : '';
	$sort = isset($_POST['sort']) ? $_POST['sort'] : '';

	if($dowhat == '')
	{
		header("Location: ./admin_log.php?pid=$pid&error_b=true");
		exit;
	}
	if(empty($logs))
	{
		header("Location: ./admin_log.php?pid=$pid&error_a=true");
		exit;
	}

	switch ($dowhat)
	{
		case 'del_log':
			foreach($logs as $key=>$value)
			{
				$emBlog->deleteLog($key);
			}
			$CACHE->mc_sta();
			$CACHE->mc_record();
			$CACHE->mc_comment();
			$CACHE->mc_logtags();
			$CACHE->mc_tags();
			$CACHE->mc_newlog();
			$CACHE->mc_logsort();
			$CACHE->mc_sort();
			if($pid == 'draft')
			{
				header("Location: ./admin_log.php?pid=draft&active_del=true");
			}else{
				header("Location: ./admin_log.php?active_del=true");
			}
			break;
		case 'top':
			foreach($logs as $key=>$value)
			{
				$emBlog->updateLog(array('top'=>'y'),$key);
			}
			header("Location: ./admin_log.php?active_up=true");
			break;
		case 'notop':
			foreach($logs as $key=>$value)
			{
				$emBlog->updateLog(array('top'=>'n'),$key);
			}
			header("Location: ./admin_log.php?active_down=true");
			break;
		case 'hide':
			foreach($logs as $key=>$value)
			{
				$emBlog->hideSwitch($key, 'y');
			}
			$CACHE->mc_sta();
			$CACHE->mc_record();
			$CACHE->mc_logtags();
			$CACHE->mc_logatts();
			$CACHE->mc_newlog();
			$CACHE->mc_logsort();
			$CACHE->mc_sort();
			$CACHE->mc_tags();
			$CACHE->mc_comment();

			header("Location: ./admin_log.php?active_hide=true");
			break;
		case 'show':
			foreach($logs as $key=>$value)
			{
				$emBlog->hideSwitch($key, 'n');
			}

			$CACHE->mc_sta();
			$CACHE->mc_record();
			$CACHE->mc_logtags();
			$CACHE->mc_logatts();
			$CACHE->mc_newlog();
			$CACHE->mc_logsort();
			$CACHE->mc_sort();
			$CACHE->mc_tags();
			$CACHE->mc_comment();

			header("Location: ./admin_log.php?pid=draft&active_post=true");
			break;
		case 'move':
			foreach($logs as $key=>$value)
			{
				$emBlog->updateLog(array('sortid'=>$sort),$key);
			}
			$CACHE->mc_sort();
			$CACHE->mc_logsort();
			header("Location: ./admin_log.php?active_move=true");
			break;
	}
}

//删除日志/草稿
if ($action == 'dellog' || $action == 'deldraft')
{
	$gid = isset($_GET['gid']) ? intval($_GET['gid']) : '';
	$emBlog->deleteLog($gid);
	$CACHE->mc_sta();
	$CACHE->mc_record();
	$CACHE->mc_comment();
	$CACHE->mc_logtags();
	$CACHE->mc_tags();
	$CACHE->mc_newlog();
	$CACHE->mc_sort();
	if($action == 'dellog')
	{
		header("Location: ./admin_log.php?active_del=true");
	}else{
		header("Location: ./admin_log.php?pid=draft&active_del=true");
	}
}
?>