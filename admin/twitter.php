<?php
/**
 * 笔记
 * @package EMLOG (www.emlog.net)
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

$Twitter_Model = new Twitter_Model();

if (empty($action)) {
	$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

	$tws = $Twitter_Model->getTwitters($page, 1);
	$twnum = $Twitter_Model->getTwitterNum(1);
	$pageurl = pagination($twnum, Option::get('admin_perpage_num'), $page, 'twitter.php?page=');
	$avatar = empty($user_cache[UID]['avatar']) ? './views/images/avatar.jpg' : '../' . $user_cache[UID]['avatar'];

	include View::getView('header');
	require_once View::getView('twitter');
	include View::getView('footer');
	View::output();
}

if ($action == 'post') {
	$t = isset($_POST['t']) ? addslashes(trim($_POST['t'])) : '';
	$img = isset($_POST['img']) ? addslashes(trim($_POST['img'])) : '';

	LoginAuth::checkToken();

	if (!$t) {
		emDirect("twitter.php?error_a=1");
	}

	$tdata = array(
		'content' => $t,
		'author'  => UID,
		'date'    => time(),
		'img'     => str_replace('../', '', $img)
	);

	$twid = $Twitter_Model->addTwitter($tdata);
	$CACHE->updateCache(array('sta', 'newtw'));
	emDirect("twitter.php?active_t=1");
}

// del note
if ($action == 'del') {
	LoginAuth::checkToken();
	$id = isset($_GET['id']) ? (int)$_GET['id'] : '';
	$Twitter_Model->delTwitter($id);
	$CACHE->updateCache(array('sta', 'newtw'));
	emDirect("twitter.php?active_del=1");
}
