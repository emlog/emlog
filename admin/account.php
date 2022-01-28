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
$admin_path_code = isset($_GET['s']) ? addslashes(htmlClean($_GET['s'])) : '';

if (!isset($_SESSION)) {
	session_start();
}

/**
 * 登录
 */
if ($action == 'signin') {
	loginAuth::loggedPage();
	if (defined('ADMIN_PATH_CODE') && $admin_path_code !== ADMIN_PATH_CODE) {
		show_404_page(true);
	}
	$ckcode = Option::get('login_code') == 'y' ? true : false;

	require_once View::getAdmView('user_head');
	require_once View::getAdmView('login');
	View::output();
}

if ($action == 'login') {
	loginAuth::loggedPage();
	if (defined('ADMIN_PATH_CODE') && $admin_path_code !== ADMIN_PATH_CODE) {
		show_404_page(true);
	}
	$username = isset($_POST['user']) ? addslashes(trim($_POST['user'])) : '';
	$password = isset($_POST['pw']) ? addslashes(trim($_POST['pw'])) : '';
	$ispersis = isset($_POST['ispersis']) ? (int)$_POST['ispersis'] : 0;
	$img_code = Option::get('login_code') == 'y' && isset($_POST['imgcode']) ? addslashes(trim(strtoupper($_POST['imgcode']))) : '';

	$uid = LoginAuth::checkUser($username, $password, $img_code);

	switch ($uid) {
		case $uid > 0:
			Register::isRegServer();
			$User_Model = new User_Model();
			$User_Model->updateUser(['ip' => getIp()], $uid);
			LoginAuth::setAuthCookie($username, $ispersis);
			emDirect("./");
			break;
		case LoginAuth::LOGIN_ERROR_AUTHCODE:
			emDirect("./account.php?action=signin&err_ckcode=1");
			break;
		case LoginAuth::LOGIN_ERROR_USER:
		case LoginAuth::LOGIN_ERROR_PASSWD:
			emDirect("./account.php?action=signin&err_login=1");
			break;
	}
}

/**
 * 注册
 */
if ($action == 'signup') {
	loginAuth::loggedPage();
	$ckcode = Option::get('login_code') == 'y' ? true : false;
	$error_msg = '';

	include View::getAdmView('user_head');
	require_once View::getAdmView('register');
	View::output();
}

if ($action == 'register') {
	loginAuth::loggedPage();
	$User_Model = new User_Model();

	$username = isset($_POST['user']) ? addslashes(trim($_POST['user'])) : '';
	$passwd = isset($_POST['passwd']) ? addslashes(trim($_POST['passwd'])) : '';
	$repasswd = isset($_POST['repasswd']) ? addslashes(trim($_POST['repasswd'])) : '';
	$img_code = isset($_POST['imgcode']) ? addslashes(trim(strtoupper($_POST['imgcode']))) : '';

	if (!$username) {
		emDirect('./account.php?action=signup&error_login=1');
	}
	if ($User_Model->isUserExist($username)) {
		emDirect('./account.php?action=signup&error_exist=1');
	}
	if (strlen($passwd) < 6) {
		emDirect('./account.php?action=signup&error_pwd_len=1');
	}
	if ($passwd !== $repasswd) {
		emDirect('./account.php?action=signup&error_pwd2=1');
	}

	$session_code = $_SESSION['code'] ?? '';
	if ((!$img_code || $img_code !== $session_code) && Option::get('login_code') === 'y') {
		unset($_SESSION['code']);
		emDirect('./account.php?action=signup&err_ckcode=1');
	}

	$PHPASS = new PasswordHash(8, true);
	$passwd = $PHPASS->HashPassword($passwd);

	$User_Model->addUser($username, $passwd, User::ROLE_WRITER, 1);
	$CACHE->updateCache(array('sta', 'user'));
	emDirect("./account.php?action=signin&succ_reg=1");
}

/**
 * 重置密码
 */
if ($action == 'reset') {
	if (ISLOGIN === true) {
		emDirect("../admin");
	}

	$ckcode = Option::get('login_code') == 'y' ? true : false;
	$error_msg = '';

	include View::getAdmView('user_head');
	require_once View::getAdmView('reset');
	View::output();
}

if ($action == 'reset_password') {
	if (ISLOGIN === true) {
		emDirect("../admin");
	}
	include View::getAdmView('user_head');
	require_once View::getAdmView('reset');
	View::output();
}

if ($action == 'send_auth_code') {
	$to_user = "xxxx@gmail.com";
	$title = "测试邮件发送标题";
	$content = "测试邮件发送内容";
	$sendmail_model = new SendMail();
	$ret = $sendmail_model->send($to_user, $title, $content);
	if ($ret) {
		echo "邮件发送成功";
	} else {
		echo "邮件发送失败";
	}
}

/**
 * 登出
 */
if ($action == 'logout') {
	setcookie(AUTH_COOKIE_NAME, ' ', time() - 31536000, '/');
	emDirect("../");
}
