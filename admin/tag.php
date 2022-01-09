<?php
/**
 * Tags Management
 * @package EMLOG (www.emlog.net)
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

$Tag_Model = new Tag_Model();

if (empty($action)) {
	$tags = $Tag_Model->getTag();
	include View::getAdmView('header');
	require_once View::getAdmView('tag');
	include View::getAdmView('footer');
	View::output();
}

//Update Tags
if ($action == 'update_tag') {
	$tagName = isset($_POST['tagname']) ? addslashes($_POST['tagname']) : '';
	$tagId = isset($_POST['tid']) ? (int)$_POST['tid'] : '';

	if (empty($tagName)) {
		emDirect("tag.php?error_a=1");
	}

	$Tag_Model->updateTagName($tagId, $tagName);
	$CACHE->updateCache(array('tags', 'logtags'));
	emDirect("./tag.php?active_edit=1");
}

//Bulk Delete Tags
if ($action == 'del_tag') {
	$tid = isset($_GET['tid']) ? (int)$_GET['tid'] : '';

	LoginAuth::checkToken();

	if (!$tid) {
		emDirect("./tag.php?error_a=1");
	}

	$Tag_Model->deleteTag($tid);

	$CACHE->updateCache(array('tags', 'logtags'));
	emDirect("./tag.php?active_del=1");
}
