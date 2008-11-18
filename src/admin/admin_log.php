<?php
/**
 * 管理日志
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-3.0.0
 * $Id$
 */

require_once('./globals.php');
require_once(EMLOG_ROOT.'/model/C_blog.php');

$emBlog = new emBlog($DB);

//显示日志(草稿)管理页面
if($action == '')
{
	$pid = isset($_GET['pid']) ? $_GET['pid'] : '';

	$sortView = (isset($_GET['sortView']) && $_GET['sortView'] == 'ASC') ?  'DESC' : 'ASC';
	$sortComm = (isset($_GET['sortComm']) && $_GET['sortComm'] == 'ASC') ?  'DESC' : 'ASC';
	$sortDate = (isset($_GET['sortDate']) && $_GET['sortDate'] == 'DESC') ?  'ASC' : 'DESC';
	$sortTitle = (isset($_GET['sortTitle']) && $_GET['sortTitle'] == 'DESC') ?  'ASC' : 'DESC';

	$sqlSegment = 'ORDER BY ';
	if(isset($_GET['sortView']))
	{
		$sqlSegment .= "views $sortView";
	}elseif(isset($_GET['sortComm'])){
		$sqlSegment .= "comnum $sortComm";
	}elseif(isset($_GET['sortDate'])){
		$sqlSegment .= "date $sortDate";
	}elseif(isset($_GET['sortTitle'])){
		$sqlSegment .= "title $sortTitle";
	}else {
		$sqlSegment .= 'top DESC,date DESC';
	}

	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$hide_state = $pid ? 'y' : 'n';
	if($pid == 'draft')
	{
		$log_act = "<input type=\"radio\" value=\"show\" name=\"modall\" />发布";
		$hide_stae = 'y';
		$sorturl = '&pid=draft';
		$pwd = '草稿箱';
	}else{
		$log_act = "<input type=\"radio\" value=\"top\" name=\"modall\" />推荐
        	 	 	<input type=\"radio\" value=\"notop\" name=\"modall\" /> 取消推荐
				 	<input type=\"radio\" value=\"hide\" name=\"modall\" />转入草稿箱";
		$hide_stae = 'n';
		$sorturl = '';
		$pwd = '日志管理';
	}

	$logNum = $emBlog->getLogNum($hide_state);
	$logs = $emBlog->getLog($sqlSegment, $hide_state, $page);

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

	if($dowhat == '')
	{
		formMsg('请选择一个要执行的操作','javascript:history.back(-1);',0);
	}
	$logs = isset($_POST['blog']) ? $_POST['blog'] : '';
	if(empty($logs))
	{
		formMsg('请选择要执行操作的日志','javascript:history.back(-1);',0);
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
			if($pid == 'draft')
			{
				header("Location: ./admin_log.php?pid=draft");
			}else{
				header("Location: ./admin_log.php");
			}
			break;
		case 'top':
			foreach($logs as $key=>$value)
			{
				$emBlog->updateLog(array('top'=>'y'),$key);
			}
			header("Location: ./admin_log.php");
			break;
		case 'notop':
			foreach($logs as $key=>$value)
			{
				$emBlog->updateLog(array('top'=>'n'),$key);
			}
			header("Location: ./admin_log.php");
			break;
		case 'hide':
			foreach($logs as $key=>$value)
			{
				$emBlog->hideSwitch($key, 'y');
			}
			$CACHE->mc_sta();
			$CACHE->mc_record();
			$CACHE->mc_comment();
			$CACHE->mc_logtags();
			$CACHE->mc_newlog();
			formMsg('日志成功转入草稿箱','./admin_log.php',1);
			break;
		case 'show':
			foreach($logs as $key=>$value)
			{
				$emBlog->hideSwitch($key, 'n');
			}
			$CACHE->mc_sta();
			$CACHE->mc_comment();
			$CACHE->mc_logtags();
			$CACHE->mc_record();
			$CACHE->mc_newlog();
			formMsg('发布成功','./admin_log.php?pid=draft',1);
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
	if($action == 'dellog')
	{
		header("Location: ./admin_log.php");
	}else{
		header("Location: ./admin_log.php?pid=draft");
	}
}
?>