<?php
/**
 * 引用通告管理
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.6.0
 */

require_once('./globals.php');

if($action == ''){

	include getViews('header');

	$result =$DB->query("SELECT * FROM ".$db_prefix."trackback ORDER BY tbid ASC");
	while($rows=$DB->fetch_array($result)){
		$rows['title']=htmlspecialchars($rows['title']);
		$rows['blog_name']=htmlspecialchars($rows['blog_name']);
		$rows['date'] = date("Y/n/j/h",$rows['date']);
		$rows['rowbg'] = getRowbg();
		
		$trackback[] = $rows;
	}
	require_once(getViews('trackback'));
	include getViews('footer');cleanPage();
	}
//删除引用
if ($action== 'del_tb'){
	$tbid = isset($_GET['tbid'])?intval($_GET['tbid']):'';
	$sql = "SELECT gid FROM ".$db_prefix."trackback WHERE tbid=$tbid";
	$blog = $DB->fetch_one_array($sql);
	$DB->query("UPDATE ".$db_prefix."blog SET tbcount=tbcount-1 WHERE gid=".$blog['gid']);
	$DB->query("DELETE FROM ".$db_prefix."trackback where tbid='$tbid' ");
	$MC->mc_sta('../cache/sta');
	formMsg('删除引用成功','javascript:history.go(-1);',1);
}

###################批量删除引用###############
if($action== 'dell_all_tb') {	
	if(!isset($_POST['tb']))
		formMsg('请选择要删除的引用','javascript:history.go(-1);',0);
	else{
		foreach($_POST['tb'] as $key=>$value) {
			$sql = "SELECT gid FROM ".$db_prefix."trackback WHERE tbid='$key' ";
			$blog = $DB->fetch_one_array($sql);
			$DB->query("UPDATE ".$db_prefix."blog SET tbcount=tbcount-1 WHERE gid='".$blog['gid']."'");
			$DB->query("DELETE FROM ".$db_prefix."trackback where tbid='$key' ");
		}
		$MC->mc_sta('../cache/sta');
		formMsg('引用删除成功','./trackback.php',1);
	}
}
?>
