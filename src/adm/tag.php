<?php
/**
 * 标签管理
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.6.5
 */

require_once('./globals.php');

if($action == ''){

	include getViews('header');

	$result =$DB->query("SELECT tagname,tid FROM {$db_prefix}tag ");
	while($rows=$DB->fetch_array($result)){
		$rows['tagname'] = htmlspecialchars($rows['tagname']);
		$tags[] = $rows;
	}
 	require_once(getViews('tag'));
	include getViews('footer');cleanPage();
}

//标签修改
if ($action== "mod_tag"){

	include getViews('header');
	$tid = isset($_GET['tid'])?intval($_GET['tid']):'';
	$tags=$DB->fetch_one_array("SELECT tagname,tid FROM {$db_prefix}tag WHERE tid='$tid' ");
	$tagname = htmlspecialchars(trim($tags['tagname']));
	$tagid = $tags['tid'];

	require_once(getViews('tagedit'));
	include getViews('footer');cleanPage();
	
}
if($action=='update_tag'){
	$tagname = isset($_POST['tagname'])?addslashes($_POST['tagname']):'';
	$tid = isset($_POST['tid'])?intval($_POST['tid']):'';
	$sql="UPDATE {$db_prefix}tag SET tagname='$tagname' WHERE tid='$tid' ";
	$DB->query($sql);
	$MC->mc_logtags('../cache/log_tags');
	$MC->mc_tags('../cache/tags');
	formMsg('标签修改成功','javascript:history.go(-2);',1);
}

###################批量删除标签###############
if($action== 'dell_all_tag')
{
	if(!isset($_POST['tag']))
	{
		formMsg('请选择要删除的标签','javascript:history.go(-1);',0);
	}else{
		foreach($_POST['tag'] as $key=>$value)
		{
			$DB->query("DELETE FROM {$db_prefix}tag where tid='$key' ");
		}
		$MC->mc_logtags('../cache/log_tags');
		$MC->mc_tags('../cache/tags');
		formMsg('标签删除成功','./tag.php',1);
	}
}
?>
