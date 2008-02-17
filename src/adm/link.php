<?php
/**
 * 友站管理
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.6.0
 */

require_once('./globals.php');

if($action == '')
{
	include getViews('header');
	$rs=$DB->query("SELECT * FROM {$db_prefix}link ORDER BY taxis ASC");
	while($rows=$DB->fetch_array($rs))
	{
		$rows['sitename'] = htmlspecialchars($rows['sitename']);
		$rows['description'] = subString(htmlClean2($rows['description']),0,80);
		$rows['siteurl'] = $rows['siteurl'];
		$rows['rowbg'] = getRowbg();
		$links[] = $rows;
	}
	require_once(getViews('links'));
	include getViews('footer');cleanPage();
}

##################友情站点排序##################
if ($action== 'link_taxis')
{
	$link=$_POST['link'];
	if(!empty($link))
	{
		foreach($link as $key=>$value)
		{
			$value = intval($value);
			$DB->query("UPDATE {$db_prefix}link SET taxis='$value'  WHERE id='$key' ");
		}
		$MC->mc_link('../cache/links');
		formMsg('站点排序更新成功','./link.php',1);
	}
	formMsg('没有可排序项目','./link.php',0);
}
##################添加友情站点##################
if($action== 'addlink')
{
	if($_POST['sitename']=='' || $_POST['siteurl']=='')
	{
		formMsg('站点名称和地址不能为空','javascript:history.go(-1);',0);
	}
	$stitename=addslashes(trim($_POST['sitename']));
	$siteurl=addslashes(trim($_POST['siteurl']));
	$description=addslashes(trim($_POST['description']));
	$sql=" insert into {$db_prefix}link (sitename,siteurl,description) values(' ".$stitename." ',' ".$siteurl." ',' ".$description." ')";
	$DB->query($sql);
	$MC->mc_link('../cache/links');
	formMsg( '友情站点添加成功','./link.php',1);
}
####################友情站点修改编辑####################

if ($action== 'mod_link')
{
	include getViews('header');
	
	$sql = "select * from {$db_prefix}link where id='".$_GET['linkid']."' "; 
	$result =$DB->query($sql);
	$show_link=$DB->fetch_array($result);
	$sitename=htmlspecialchars(trim($show_link['sitename']));
	$siteurl=htmlspecialchars(trim($show_link['siteurl']));
	$description=htmlspecialchars(trim($show_link['description']));
	$linkid = $show_link['id'];

	require_once(getViews('linkedit'));
	include getViews('footer');cleanPage();
}

if($action=='update_link')
{
	$sql=" UPDATE {$db_prefix}link SET 
	sitename='".addslashes($_POST['sitename'])."',
	siteurl='".addslashes($_POST['siteurl'])."',
	description='".addslashes($_POST['description'])."' where id='".intval($_POST['linkid'])."' ";
	$DB->query($sql);
	$MC->mc_link('../cache/links');
	formMsg("修改成功","./link.php",1);
}
//删除友情连接
if ($action== 'dellink')
{
	$linkid = isset($_GET['linkid'])?intval($_GET['linkid']):'';
	$DB->query("DELETE FROM {$db_prefix}link where id=$linkid");
	$MC->mc_link('../cache/links');
	formMsg('删除成功','./link.php',1);
}
?>