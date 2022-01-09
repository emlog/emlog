<?php
/**
 * Notes
 * @package EMLOG (www.emlog.net)
 */

/**
 * @var string $action
 * @var object $CACHE
 */

const TW_PAGE_COUNT = 20; // Number of notes displayed per page

require_once 'globals.php';

$Twitter_Model = new Twitter_Model();

if (empty($action)) {
	$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

	$tws = $Twitter_Model->getTwitters($page, TW_PAGE_COUNT);
	$twnum = $Twitter_Model->getTwitterNum();
	$pageurl = pagination($twnum, TW_PAGE_COUNT, $page, 'twitter.php?page=');
	$avatar = empty($user_cache[UID]['avatar']) ? './views/images/avatar.jpg' : '../' . $user_cache[UID]['avatar'];

	include View::getAdmView('header');
	require_once View::getAdmView('twitter');
	include View::getAdmView('footer');
	View::output();
}

if ($action == 'post') {
	$t = isset($_POST['t']) ? addslashes(trim($_POST['t'])) : '';

	LoginAuth::checkToken();

	if (!$t) {
		emDirect("twitter.php?error_a=1");
	}

	$tdata = [
		'content' => $t,
		'author'  => UID,
		'date'    => time(),
	];

	$twid = $Twitter_Model->addTwitter($tdata);
	$CACHE->updateCache(array('sta', 'newtw'));
	emDirect("twitter.php?active_t=1");
}

if ($action == 'del') {
	LoginAuth::checkToken();
	$id = isset($_GET['id']) ? (int)$_GET['id'] : '';
	$Twitter_Model->delTwitter($id);
	$CACHE->updateCache(array('sta', 'newtw'));
	emDirect("twitter.php?active_del=1");
}
