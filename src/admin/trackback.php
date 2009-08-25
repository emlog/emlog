<?php
/**
 * 引用通告管理
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.3.0
 * $Id$
 */

require_once('globals.php');
require_once(EMLOG_ROOT.'/model/C_trackback.php');

$emTrackback = new emTrackback($DB);

if($action == '')
{
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

	$trackback = $emTrackback->getTrackbacks($page, null, 1);
	$tbnum = $emTrackback->getTbNum();
	$pageurl =  pagination($tbnum, ADMIN_PERPAGE_NUM, $page, "./trackback.php?page");

	include getViews('header');
	require_once(getViews('trackback'));
	include getViews('footer');cleanPage();
}
//删除引用
if($action == 'dell')
{
	$tbs = isset($_POST['tb']) ? array_map('intval', $_POST['tb']) : array();
	if(!$tbs)
	{
		header("Location: ./trackback.php?error_a=true");
		exit;
	}
	foreach($tbs as $value)
	{
		$emTrackback->deleteTrackback($value);
	}
	$CACHE->mc_sta();
	$CACHE->mc_user();
	header("Location: ./trackback.php?active_del=true");
}

?>
