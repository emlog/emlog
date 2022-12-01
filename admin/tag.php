<?php
/**
 * tags
 * @package EMLOG
 * @link https://www.emlog.net
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

$Tag_Model = new Tag_Model();

if (empty($action)) {
	$page_count = 260;
	$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
	$tags = $Tag_Model->getTags($page_count, $page);
	$tags_count = $Tag_Model->getTagsCount();
	$pageurl = pagination($tags_count, $page_count, $page, "./tag.php?page=");

	include View::getAdmView('header');
	require_once View::getAdmView('tag');
	include View::getAdmView('footer');
	View::output();
}

if ($action == 'update_tag') {
	$tagName = isset($_POST['tagname']) ? addslashes($_POST['tagname']) : '';
	$tagId = isset($_POST['tid']) ? (int)$_POST['tid'] : '';

	if (empty($tagName)) {
		emDirect("tag.php?error_a=1");
	}

	$Tag_Model->updateTagName($tagId, $tagName);
	$CACHE->updateCache(tags);
	emDirect("./tag.php?active_edit=1");
}

if ($action == 'del_tag') {
	$tid = isset($_GET['tid']) ? (int)$_GET['tid'] : '';

	LoginAuth::checkToken();

	if (!$tid) {
		emDirect("./tag.php?error_a=1");
	}

	$Tag_Model->deleteTag($tid);

	$CACHE->updateCache('tags');
	emDirect("./tag.php?active_del=1");
}
