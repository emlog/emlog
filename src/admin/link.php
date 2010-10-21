<?php
/**
 * 链接管理
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

require_once 'globals.php';

$Link_Model = new Link_Model();

if($action == '')
{
	$links = $Link_Model->getLinks();
	include View::getView('header');
	require_once(View::getView('links'));
	include View::getView('footer');
	View::output();
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
			$Link_Model->updateLink(array('taxis'=>$value), $key);
		}
		$CACHE->updateCache('link');
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
	$Link_Model->addLink($sitename, $siteurl, $description);
	$CACHE->updateCache('link');
	header("Location: ./link.php?active_add=true");
}

if ($action== 'mod_link')
{
	$linkId = isset($_GET['linkid']) ? intval($_GET['linkid']) : '';

	$linkData = $Link_Model->getOneLink($linkId);
	extract($linkData);

	include View::getView('header');
	require_once(View::getView('linkedit'));
	include View::getView('footer');View::output();
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

	$Link_Model->updateLink(array('sitename'=>$sitename, 'siteurl'=>$siteurl, 'description'=>$description), $linkId);

	$CACHE->updateCache('link');
	header("Location: ./link.php?active_edit=true");
}
if ($action== 'dellink')
{
	$linkid = isset($_GET['linkid']) ? intval($_GET['linkid']) : '';
	$Link_Model->deleteLink($linkid);
	$CACHE->updateCache('link');
	header("Location: ./link.php?active_del=true");
}
