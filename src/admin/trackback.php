<?php
/**
 * Trackbacks Management
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'globals.php';

$Trackback_Model = new Trackback_Model();

if($action == '')
{
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

	$trackback = $Trackback_Model->getTrackbacks($page, null, 1);
	$tbnum = $Trackback_Model->getTbNum();
	$pageurl =  pagination($tbnum, Option::get('admin_perpage_num'), $page, "./trackback.php?page=");

	include View::getView('header');
	require_once View::getView('trackback');
	include View::getView('footer');View::output();
}
//Delete Trackback
if($action == 'dell')
{
	$tbs = isset($_POST['tb']) ? array_map('intval', $_POST['tb']) : array();
	if(!$tbs)
	{
		emDirect("./trackback.php?error_a=true");
	}
	foreach($tbs as $value)
	{
		$Trackback_Model->deleteTrackback($value);
	}
	$CACHE->updateCache('sta');
	emDirect("./trackback.php?active_del=true");
}
