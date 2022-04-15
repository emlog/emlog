<?php
/**
 * 后台全局项加载
 * @package EMLOG
 * @link https://www.emlog.net
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once '../init.php';

$sta_cache = $CACHE->readCache('sta');
$user_cache = $CACHE->readCache('user');
$action = isset($_GET['action']) ? addslashes($_GET['action']) : '';

loginAuth::checkLogin();

User::checkRolePermission();

if (!Register::isRegLocal() && mt_rand(1, 15) === 10) {
	emDirect("auth.php");
}
