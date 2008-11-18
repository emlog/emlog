<?php
/**
 * 友站管理
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-3.0.0
 * $Id$
 */

require_once('./globals.php');
require_once(EMLOG_ROOT.'/model/C_link.php');

$emLink = new emLink($DB);

if($action == '')
{
	$links = $emLink->getLinks();
	include getViews('header');
	require_once(getViews('links'));
	include getViews('footer');
	cleanPage();
}
//排序
if ($action== 'link_taxis')
{
	$link = isset($_POST['link']) ? $_POST['link'] : '';
	if(!empty($link))
	{
		foreach($link as $key=>$value)
		{
			$value = intval($value);
			$emLink->updateLink(array('taxis'=>$value), $key);
		}
		$CACHE->mc_link();
		formMsg('站点排序更新成功','./link.php',1);
	}
	formMsg('没有可排序项目','./link.php',0);
}
//添加
if($action== 'addlink')
{
	$sitename = isset($_POST['sitename']) ? addslashes(trim($_POST['sitename'])) : '';
	$siteurl = isset($_POST['siteurl']) ? addslashes(trim($_POST['siteurl'])) : '';
	$description = isset($_POST['description']) ? addslashes(trim($_POST['description'])) : '';

	if($sitename =='' || $siteurl =='')
	{
		formMsg('站点名称和地址不能为空','javascript:history.go(-1);',0);
	}
	$emLink->addLink($sitename, $siteurl, $description);
	$CACHE->mc_link();
	header("Location: ./link.php");
}
//修改
if ($action== 'mod_link')
{
	$linkId = isset($_GET['linkid']) ? intval($_GET['linkid']) : '';

	$linkData = $emLink->getOneLink($linkId);
	extract($linkData);

	include getViews('header');
	require_once(getViews('linkedit'));
	include getViews('footer');cleanPage();
}
if($action=='update_link')
{
	$sitename = isset($_POST['sitename']) ? addslashes(trim($_POST['sitename'])) : '';
	$siteurl = isset($_POST['siteurl']) ? addslashes(trim($_POST['siteurl'])) : '';
	$description = isset($_POST['description']) ? addslashes(trim($_POST['description'])) : '';
	$linkId = isset($_POST['linkid']) ? intval($_POST['linkid']) : '';

	$emLink->updateLink(array('sitename'=>$sitename, 'siteurl'=>$siteurl, 'description'=>$description), $linkId);

	$CACHE->mc_link();
	header("Location: ./link.php");
}
//删除
if ($action== 'dellink')
{
	$linkid = isset($_GET['linkid']) ? intval($_GET['linkid']) : '';
	$emLink->deleteLink($linkid);
	$CACHE->mc_link();
	header("Location: ./link.php");
}

?>
