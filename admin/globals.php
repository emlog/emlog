<?php
/**
 * 后台全局项加载
 * @package EMLOG (www.emlog.net)
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once '../init.php';

$sta_cache = $CACHE->readCache('sta');
$user_cache = $CACHE->readCache('user');
$action = isset($_GET['action']) ? addslashes($_GET['action']) : '';

loginAuth::loginPage();

$request_uri = strtolower(substr(basename($_SERVER['SCRIPT_NAME']), 0, -4));
if (ROLE === User::ROLE_WRITER && !in_array($request_uri, array('article_write', 'article', 'twitter', 'media', 'blogger', 'comment', 'index', 'article_save'))) {
	emMsg('权限不足！', './');
}

if (!Register::isRegLocal() && mt_rand(1, 15) === 10) {
	emDirect("auth.php");
}
