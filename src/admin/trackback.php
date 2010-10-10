<?php
/**
 * 引用通告管理
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

require_once 'globals.php';

$emTrackback = new emTrackback();

if($action == '')
{
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

	$trackback = $emTrackback->getTrackbacks($page, null, 1);
	$tbnum = $emTrackback->getTbNum();
	$pageurl =  pagination($tbnum, Option::get('admin_perpage_num'), $page, "./trackback.php?page");

	include View::getView('header');
	require_once View::getView('trackback');
	include View::getView('footer');View::output();
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
	$CACHE->updateCache('sta');
	header("Location: ./trackback.php?active_del=true");
}
