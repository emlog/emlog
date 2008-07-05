<?php
/**
 * 引用通告管理
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.7.0
 * $Id$
 */

require_once('./globals.php');

if($action == '')
{
	include getViews('header');

	$page = intval(isset($_GET['page'])?$_GET['page']:1);
	if (!empty($page)){
		$start_limit = ($page - 1) *15;
	} else {
		$start_limit = 0;
		$page = 1;
	}
	$query=$DB->query("SELECT tbid FROM {$db_prefix}trackback");
	$num=$DB->num_rows($query);
	
	$trackback = array();
	$result =$DB->query("SELECT * FROM {$db_prefix}trackback ORDER BY tbid DESC LIMIT $start_limit, 15");
	while($rows=$DB->fetch_array($result)){
		$rows['title']=htmlspecialchars($rows['title']);
		$rows['blog_name']=htmlspecialchars($rows['blog_name']);
		$rows['date'] = date("Y-m-d H:i",$rows['date']);
		$rows['rowbg'] = getRowbg();
		
		$trackback[] = $rows;
	}
	
	$pageurl =  pagination($num,15,$page,"trackback.php?page");
	
	require_once(getViews('trackback'));
	include getViews('footer');cleanPage();
}
//删除引用
if ($action== 'del_tb'){
	$tbid = isset($_GET['tbid'])?intval($_GET['tbid']):'';
	$sql = "SELECT gid FROM {$db_prefix}trackback WHERE tbid=$tbid";
	$blog = $DB->fetch_one_array($sql);
	$DB->query("UPDATE {$db_prefix}blog SET tbcount=tbcount-1 WHERE gid=".$blog['gid']);
	$DB->query("DELETE FROM {$db_prefix}trackback where tbid='$tbid' ");
	$MC->mc_sta('../cache/sta');
	formMsg('删除引用成功','./trackback.php',1);
}

###################批量删除引用###############
if($action== 'dell_all_tb') {	
	if(!isset($_POST['tb']))
		formMsg('请选择要删除的引用','javascript:history.go(-1);',0);
	else{
		foreach($_POST['tb'] as $key=>$value) {
			$sql = "SELECT gid FROM {$db_prefix}trackback WHERE tbid='$key' ";
			$blog = $DB->fetch_one_array($sql);
			$DB->query("UPDATE {$db_prefix}blog SET tbcount=tbcount-1 WHERE gid='".$blog['gid']."'");
			$DB->query("DELETE FROM {$db_prefix}trackback where tbid='$key' ");
		}
		$MC->mc_sta('../cache/sta');
		formMsg('引用删除成功','./trackback.php',1);
	}
}
?>
