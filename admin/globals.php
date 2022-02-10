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

loginAuth::checkLogin();

User::checkRolePermission();

if (!Register::isRegLocal() && mt_rand(1, 15) === 10) {
	emDirect("auth.php");
}
