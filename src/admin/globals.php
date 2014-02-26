<?php
/**
 * 后台全局项加载
 * @copyright (c) Emlog All Rights Reserved
 */

require_once '../init.php';

define('TEMPLATE_PATH', EMLOG_ROOT.'/admin/views/');//后台当前模板路径
define('OFFICIAL_SERVICE_HOST', 'http://www.emlog.net/');//官方服务域名

$sta_cache = $CACHE->readCache('sta');
$user_cache = $CACHE->readCache('user');
$action = isset($_GET['action']) ? addslashes($_GET['action']) : '';

//登录验证
if ($action == 'login') {
	$username = isset($_POST['user']) ? addslashes(trim($_POST['user'])) : '';
	$password = isset($_POST['pw']) ? addslashes(trim($_POST['pw'])) : '';
	$ispersis = isset($_POST['ispersis']) ? intval($_POST['ispersis']) : false;
	$img_code = Option::get('login_code') == 'y' && isset($_POST['imgcode']) ? addslashes(trim(strtoupper($_POST['imgcode']))) : '';

    $loginAuthRet = LoginAuth::checkUser($username, $password, $img_code);
    
	if ($loginAuthRet === true) {
		LoginAuth::setAuthCookie($username, $ispersis);
		emDirect("./");
	} else{
		LoginAuth::loginPage($loginAuthRet);
	}
}

//提交来源验证
$referer_url = filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL);

//如果POST提交没有任何来源，则直接拒绝
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($referer_url)) {
	header('HTTP/1.0 403 Forbidden');
	echo '<h1>Forbidden</h1>';
	exit();
}

//只验证POST提交，不验证GET提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$referer_host = parse_url($referer_url, PHP_URL_HOST);
	$referer_path = parse_url($referer_url, PHP_URL_PATH);
	if (substr($referer_path, -1) === '/') {
		$referer_path .= 'index.php';
	}
	$referer_path = dirname($referer_path);
	
	$admin_url = '//' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	$admin_host = parse_url($admin_url, PHP_URL_HOST);
	$admin_path = parse_url($admin_url, PHP_URL_PATH);
	if (substr($admin_path, -1) === '/') {
		$admin_path .= 'index.php';
	}
	$admin_path = dirname($admin_path);
	
	//如果来源地址和后台地址不符，则拒绝
	if ($admin_host != $referer_host ||
		$admin_path != $referer_path) {
		header('HTTP/1.0 403 Forbidden');
		echo '<h1>Forbidden</h1>';
		exit();
	}
}

//退出
if ($action == 'logout') {
	setcookie(AUTH_COOKIE_NAME, ' ', time() - 31536000, '/');
	emDirect("../");
}

if (ISLOGIN === false) {
	LoginAuth::loginPage();
}

$request_uri = strtolower(substr(basename($_SERVER['SCRIPT_NAME']), 0, -4));
if (ROLE == ROLE_WRITER && !in_array($request_uri, array('write_log','admin_log','attachment','blogger','comment','index','save_log'))) {
	emMsg('权限不足！','./');
}
