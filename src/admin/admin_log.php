<?php
/**
 * 管理日志
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.7.0
 * $Id$
 */

require_once('./globals.php');
require_once('./model/blog.php');

$emBlog = new emBlog($DB);

//显示日志(草稿)管理页面
if($action == '')
{
	$pid = isset($_GET['pid']) ? $_GET['pid'] : '';

	$sortView = (isset($_GET['sortView']) && $_GET['sortView'] == 'ASC') ?  'DESC' : 'ASC';
	$sortComm = (isset($_GET['sortComm']) && $_GET['sortComm'] == 'ASC') ?  'DESC' : 'ASC';
	$sortDate = (isset($_GET['sortDate']) && $_GET['sortDate'] == 'DESC') ?  'ASC' : 'DESC';
	$sortTitle = (isset($_GET['sortTitle']) && $_GET['sortTitle'] == 'DESC') ?  'ASC' : 'DESC';

	$subSql = 'ORDER BY ';
	if(isset($_GET['sortView']))
	{
		$subSql .= "views $sortView";
	}elseif(isset($_GET['sortComm'])){
		$subSql .= "comnum $sortComm";
	}elseif(isset($_GET['sortDate'])){
		$subSql .= "date $sortDate";
	}elseif(isset($_GET['sortTitle'])){
		$subSql .= "title $sortTitle";
	}else {
		$subSql .= 'top DESC,date DESC';
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
	$logs = $emBlog->getLog($subSql, $hide_state, $page);

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
			$CACHE->mc_sta('sta');
			$CACHE->mc_record('records');
			$CACHE->mc_comment('comments');
			$CACHE->mc_logtags('log_tags');
			$CACHE->mc_tags('tags');
			formMsg('删除日志成功','./admin_log.php',1);
			break;
		case 'top':
			foreach($logs as $key=>$value)
			{
				$emBlog->updateLog(array('top'=>'y'),$key);
			}
			formMsg('推荐日志成功','./admin_log.php',1);
			break;
		case 'notop':
			foreach($logs as $key=>$value)
			{
				$emBlog->updateLog(array('top'=>'n'),$key);
			}
			formMsg('日志已取消推荐','./admin_log.php',1);
			break;
		case 'hide':
			foreach($logs as $key=>$value)
			{
				$emBlog->hideSwitch($key, 'y');
			}
			$CACHE->mc_sta('sta');
			$CACHE->mc_record('records');
			$CACHE->mc_comment('comments');
			$CACHE->mc_logtags('log_tags');
			formMsg('日志成功转入草稿箱','./admin_log.php',1);
			break;
		case 'show':
			foreach($logs as $key=>$value)
			{
				$emBlog->hideSwitch($key, 'n');
			}
			$CACHE->mc_sta('sta');
			$CACHE->mc_comment('comments');
			$CACHE->mc_logtags('log_tags');
			$CACHE->mc_record('records');
			formMsg('发布成功','./admin_log.php?pid=draft',1);
			break;
	}
}

//删除日志
if ($action == 'delLog')
{
	$gid = isset($_GET['gid']) ? intval($_GET['gid']) : '';
	$emBlog->deleteLog($gid);
	$CACHE->mc_sta('sta');
	$CACHE->mc_record('records');
	$CACHE->mc_comment('comments');
	$CACHE->mc_logtags('log_tags');
	$CACHE->mc_tags('tags');
	formMsg('删除日志成功','./admin_log.php',1);
}
?>