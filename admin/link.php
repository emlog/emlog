<?php
/**
 * 链接管理
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'globals.php';

$Link_Model = new Link_Model();

if ($action == '') {
	$links = $Link_Model->getLinks();
	include View::getView('header');
	require_once(View::getView('links'));
	include View::getView('footer');
	View::output();
}

if ($action == 'link_taxis') {
	$link = isset($_POST['link']) ? $_POST['link'] : '';

	if (empty($link)) {
		emDirect("./link.php?error_b=1");
	}

	foreach ($link as $key => $value) {
		$value = intval($value);
		$key = intval($key);
		$Link_Model->updateLink(array('taxis' => $value), $key);
	}
	$CACHE->updateCache('link');
	emDirect("./link.php?active_taxis=1");
}

if ($action == 'addlink') {
	$sitename = isset($_POST['sitename']) ? addslashes(trim($_POST['sitename'])) : '';
	$siteurl = isset($_POST['siteurl']) ? addslashes(trim($_POST['siteurl'])) : '';
	$description = isset($_POST['description']) ? addslashes(trim($_POST['description'])) : '';

	if ($sitename == '' || $siteurl == '') {
		emDirect("./link.php?error_a=1");
	}
	if (!preg_match("/^http|ftp.+$/i", $siteurl)) {
		$siteurl = 'http://' . $siteurl;
	}
	$Link_Model->addLink($sitename, $siteurl, $description);
	$CACHE->updateCache('link');
	emDirect("./link.php?active_add=1");
}

if ($action == 'update_link') {
	$sitename = isset($_POST['sitename']) ? addslashes(trim($_POST['sitename'])) : '';
	$siteurl = isset($_POST['siteurl']) ? addslashes(trim($_POST['siteurl'])) : '';
	$description = isset($_POST['description']) ? addslashes(trim($_POST['description'])) : '';
	$linkId = isset($_POST['linkid']) ? intval($_POST['linkid']) : '';

	if (!preg_match("/^http|ftp.+$/i", $siteurl)) {
		$siteurl = 'http://' . $siteurl;
	}

	$Link_Model->updateLink(array('sitename' => $sitename, 'siteurl' => $siteurl, 'description' => $description), $linkId);

	$CACHE->updateCache('link');
	emDirect("./link.php?active_edit=1");
}

if ($action == 'dellink') {
	LoginAuth::checkToken();
	$linkid = isset($_GET['linkid']) ? intval($_GET['linkid']) : '';
	$Link_Model->deleteLink($linkid);
	$CACHE->updateCache('link');
	emDirect("./link.php?active_del=1");
}

if ($action == 'hide') {
	$linkId = isset($_GET['linkid']) ? intval($_GET['linkid']) : '';

	$Link_Model->updateLink(array('hide' => 'y'), $linkId);

	$CACHE->updateCache('link');
	emDirect('./link.php');
}

if ($action == 'show') {
	$linkId = isset($_GET['linkid']) ? intval($_GET['linkid']) : '';

	$Link_Model->updateLink(array('hide' => 'n'), $linkId);

	$CACHE->updateCache('link');
	emDirect('./link.php');
}
