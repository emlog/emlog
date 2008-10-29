<?php
/**
 * 引用通告管理
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.7.0
 * $Id$
 */

require_once('./globals.php');
require_once('../model/C_trackback.php');

if($action == '')
{
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

	$emTrackback = new emTrackback($DB);
	$trackback = $emTrackback->getTrackback($page);
	$num = $emComment->getCommentNum($blogId);
	$pageurl =  pagination($num,15,$page,"trackback.php?page");

	include getViews('header');
	require_once(getViews('trackback'));
	include getViews('footer');cleanPage();
}
//删除引用
if ($action== 'del_tb')
{
	$tbid = isset($_GET['tbid']) ? intval($_GET['tbid']) : '';
	$sql = "SELECT gid FROM ".DB_PREFIX."trackback WHERE tbid=$tbid";
	$blog = $DB->fetch_one_array($sql);
	$DB->query("UPDATE ".DB_PREFIX."blog SET tbcount=tbcount-1 WHERE gid=".$blog['gid']);
	$DB->query("DELETE FROM ".DB_PREFIX."trackback where tbid='$tbid' ");
	$CACHE->mc_sta('sta');
	formMsg('删除引用成功','./trackback.php',1);
}

//批量删除引用
if($action== 'dell_all_tb')
{	
	if(!isset($_POST['tb']))
	{
		formMsg('请选择要删除的引用','javascript:history.go(-1);',0);
	} else {
		foreach($_POST['tb'] as $key=>$value)
		{
			$sql = "SELECT gid FROM ".DB_PREFIX."trackback WHERE tbid='$key' ";
			$blog = $DB->fetch_one_array($sql);
			$DB->query("UPDATE ".DB_PREFIX."blog SET tbcount=tbcount-1 WHERE gid='".$blog['gid']."'");
			$DB->query("DELETE FROM ".DB_PREFIX."trackback where tbid='$key' ");
		}
		$CACHE->mc_sta('sta');
		formMsg('引用删除成功','./trackback.php',1);
	}
}
?>
