<?php
/**
 * Load Background Global items
 * @package EMLOG (www.emlog.net)
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once '../init.php';


/*vot*/ load_language('admin');
$sta_cache = $CACHE->readCache('sta');
$user_cache = $CACHE->readCache('user');
$action = isset($_GET['action']) ? addslashes($_GET['action']) : '';

loginAuth::loginPage();

$request_uri = strtolower(substr(basename($_SERVER['SCRIPT_NAME']), 0, -4));
if (ROLE === User::ROLE_WRITER && !in_array($request_uri, array('article_write', 'article', 'twitter', 'media', 'blogger', 'comment', 'index', 'article_save'))) {
/*vot*/	emMsg(lang('no_permission'), './');
}

if (!Register::isRegLocal() && mt_rand(1, 15) === 10) {
	emDirect("auth.php");
}
