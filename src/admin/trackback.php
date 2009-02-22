<?php
/**
 * 引用通告管理
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.1.0
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

if ($action== 'del_tb')
{
	$tbid = isset($_GET['tbid']) ? intval($_GET['tbid']) : '';
	$emTrackback->deleteTrackback($tbid);
	$CACHE->mc_sta();
	header("Location: ./trackback.php?active_del=true");
}

if($action== 'dell_all_tb')
{
	$tbs = isset($_POST['tb']) ? $_POST['tb'] : '';
	if(!$tbs)
	{
		header("Location: ./trackback.php?error_a=true");
		exit;
	}
	foreach($tbs as $key=>$value)
	{
		$emTrackback->deleteTrackback($key);
	}
	$CACHE->mc_sta();
	header("Location: ./trackback.php?active_del=true");
}

?>
