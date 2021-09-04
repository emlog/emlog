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

const TEMPLATE_PATH = EMLOG_ROOT . '/admin/views/';              //后台模板路径
const OFFICIAL_SERVICE_HOST = 'https://www.emlog.net/';          //官方服务域名
const MSGCODE_EMKEY_INVALID = 1001;                              // 错误的注册码
const MSGCODE_NO_UPUPDATE = 1002;                                // 没有可用的版本更新
const MSGCODE_SUCCESS = 200;                                     // 成功

$sta_cache = $CACHE->readCache('sta');
$user_cache = $CACHE->readCache('user');
$action = isset($_GET['action']) ? addslashes($_GET['action']) : '';
$admin_path_code = isset($_GET['s']) ? addslashes($_GET['s']) : '';

define('ISREG', Register::isRegLocal());

if ($action == 'login') {
	if (defined('ADMIN_PATH_CODE') && $admin_path_code !== ADMIN_PATH_CODE) {
		show_404_page(true);
	}
	$username = isset($_POST['user']) ? addslashes(trim($_POST['user'])) : '';
	$password = isset($_POST['pw']) ? addslashes(trim($_POST['pw'])) : '';
	$ispersis = isset($_POST['ispersis']) ? (int)$_POST['ispersis'] : 0;
	$img_code = Option::get('login_code') == 'y' && isset($_POST['imgcode']) ? addslashes(trim(strtoupper($_POST['imgcode']))) : '';

	$loginAuthRet = LoginAuth::checkUser($username, $password, $img_code);

	if ($loginAuthRet === true) {
		Register::isRegServer();
		LoginAuth::setAuthCookie($username, $ispersis);
		emDirect("./");
	} else {
		LoginAuth::loginPage($loginAuthRet);
	}
}

if ($action == 'logout') {
	setcookie(AUTH_COOKIE_NAME, ' ', time() - 31536000, '/');
	emDirect("../");
}

if (ISLOGIN === false) {
	LoginAuth::loginPage(null, $admin_path_code);
}

$request_uri = strtolower(substr(basename($_SERVER['SCRIPT_NAME']), 0, -4));
if (ROLE === ROLE_WRITER && !in_array($request_uri, array('article_write', 'article', 'blogger', 'comment', 'index', 'article_save'))) {
	emMsg('权限不足！', './');
}

if (!ISREG && mt_rand(1,10) === 10) {
	emDirect("register.php");
}
