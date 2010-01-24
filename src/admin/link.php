<?php
/**
 * 链接管理
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.4.0
 * $Id$
 */

require_once 'globals.php';
require_once EMLOG_ROOT.'/model/class.link.php';

$emLink = new emLink($DB);

if($action == '')
{
	$links = $emLink->getLinks();
	include getViews('header');
	require_once(getViews('links'));
	include getViews('footer');
	cleanPage();
}

if ($action== 'link_taxis')
{
	$link = isset($_POST['link']) ? $_POST['link'] : '';
	if(!empty($link))
	{
		foreach($link as $key=>$value)
		{
			$value = intval($value);
			$key = intval($key);
			$emLink->updateLink(array('taxis'=>$value), $key);
		}
		$CACHE->mc_link();
		header("Location: ./link.php?active_taxis=true");
	}else {
		header("Location: ./link.php?error_b=true");
	}
}

if($action== 'addlink')
{
	$sitename = isset($_POST['sitename']) ? addslashes(trim($_POST['sitename'])) : '';
	$siteurl = isset($_POST['siteurl']) ? addslashes(trim($_POST['siteurl'])) : '';
	$description = isset($_POST['description']) ? addslashes(trim($_POST['description'])) : '';

	if($sitename =='' || $siteurl =='')
	{
		header("Location: ./link.php?error_a=true");
		exit;
	}
	if(!preg_match("/^http|ftp.+$/i", $siteurl))
	{
		$siteurl = 'http://'.$siteurl;
	}
	$emLink->addLink($sitename, $siteurl, $description);
	$CACHE->mc_link();
	header("Location: ./link.php?active_add=true");
}

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

	if(!preg_match("/^http|ftp.+$/i", $siteurl))
	{
		$siteurl = 'http://'.$siteurl;
	}

	$emLink->updateLink(array('sitename'=>$sitename, 'siteurl'=>$siteurl, 'description'=>$description), $linkId);

	$CACHE->mc_link();
	header("Location: ./link.php?active_edit=true");
}
if ($action== 'dellink')
{
	$linkid = isset($_GET['linkid']) ? intval($_GET['linkid']) : '';
	$emLink->deleteLink($linkid);
	$CACHE->mc_link();
	header("Location: ./link.php?active_del=true");
}
