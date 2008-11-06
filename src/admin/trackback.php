<?php
/**
 * 引用通告管理
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.7.0
 * $Id$
 */

require_once('./globals.php');
require_once(EMLOG_ROOT.'/model/C_trackback.php');

$emTrackback = new emTrackback($DB);

if($action == '')
{
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

	$trackback = $emTrackback->getTrackback($page);
	$num = $emTrackback->getTbNum();
	$pageurl =  pagination($num,15,$page,"trackback.php?page");

	include getViews('header');
	require_once(getViews('trackback'));
	include getViews('footer');cleanPage();
}
//删除引用
if ($action== 'del_tb')
{
	$tbid = isset($_GET['tbid']) ? intval($_GET['tbid']) : '';
	$emTrackback->deleteTrackback($tbid);
	$CACHE->mc_sta('sta');
	header("Location: ./trackback.php");
}
//批量删除引用
if($action== 'dell_all_tb')
{
	$tbs = isset($_POST['tb']) ? $_POST['tb'] : '';
	if(!$tbs)
	{
		formMsg('请选择要删除的引用','javascript:history.go(-1);',0);
	}
	foreach($tbs as $key=>$value)
	{
		$emTrackback->deleteTrackback($key);
	}
	$CACHE->mc_sta('sta');
	header("Location: ./trackback.php");
}

?>
