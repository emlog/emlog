<?php
/**
 * account administration
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
$admin_path_code = isset($_GET['s']) ? addslashes(htmlClean($_GET['s'])) : '';
$User_Model = new User_Model();

if ($action == 'signin') {
	loginAuth::checkLogged();
	if (defined('ADMIN_PATH_CODE') && $admin_path_code !== ADMIN_PATH_CODE) {
		show_404_page(true);
	}
	$login_code = Option::get('login_code') === 'y';
	$is_signup = Option::get('is_signup') === 'y';

	$page_title = '登录';
	require_once View::getAdmView('user_head');
	require_once View::getAdmView('signin');
	View::output();
}

if ($action == 'dosignin') {
	loginAuth::checkLogged();
	if (defined('ADMIN_PATH_CODE') && $admin_path_code !== ADMIN_PATH_CODE) {
		show_404_page(true);
	}
	$username = Input::postStrVar('user');
	$password = Input::postStrVar('pw');
	$persist = Input::postIntVar('persist');
	$resp = Input::postStrVar('resp'); // eg: json (only support json now)
	$login_code = Option::get('login_code') === 'y' && isset($_POST['login_code']) ? addslashes(strtoupper(trim($_POST['login_code']))) : '';

	if (!User::checkLoginCode($login_code)) {
		if ($resp === 'json') {
			Output::error('验证错误');
		}
		emDirect('./account.php?action=signin&err_ckcode=1');
	}

	$uid = LoginAuth::checkUser($username, $password);
	switch ($uid) {
		case $uid > 0:
			Register::isRegServer();
			$User_Model->updateUser(['ip' => getIp()], $uid);
			LoginAuth::setAuthCookie($username, $persist);
			if ($resp === 'json') {
				Output::ok();
			}
			emDirect("./");
			break;
		case LoginAuth::LOGIN_ERROR_USER:
		case LoginAuth::LOGIN_ERROR_PASSWD:
			if ($resp === 'json') {
				Output::error('用户或密码错误');
			}
			emDirect("./account.php?action=signin&err_login=1");
			break;
	}
}

if ($action == 'signup') {
	loginAuth::checkLogged();
	$login_code = Option::get('login_code') === 'y';
	$email_code = Option::get('email_code') === 'y';
	$error_msg = '';

	if (Option::get('is_signup') !== 'y') {
		emMsg('系统已关闭注册！');
	}

	$page_title = '注册账号';
	include View::getAdmView('user_head');
	require_once View::getAdmView('signup');
	View::output();
}

if ($action == 'dosignup') {
	loginAuth::checkLogged();

	if (Option::get('is_signup') !== 'y') {
		return;
	}

	$mail = Input::postStrVar('mail');
	$passwd = Input::postStrVar('passwd');
	$repasswd = Input::postStrVar('repasswd');
	$login_code = strtoupper(Input::postStrVar('login_code'));
	$mail_code = Input::postStrVar('mail_code');
	$resp = Input::postStrVar('resp'); // eg: json (only support json now)

	if (!checkMail($mail)) {
		if ($resp === 'json') {
			Output::error('错误的邮箱格式');
		}
		emDirect('./account.php?action=signup&error_login=1');
	}
	if (!User::checkLoginCode($login_code)) {
		if ($resp === 'json') {
			Output::error('图形验证码错误');
		}
		emDirect('./account.php?action=signup&err_ckcode=1');
	}
	if (Option::get('email_code') === 'y' && !User::checkMailCode($mail_code)) {
		if ($resp === 'json') {
			Output::error('邮件验证码错误');
		}
		emDirect('./account.php?action=signup&err_mail_code=1');
	}
	if ($User_Model->isMailExist($mail)) {
		if ($resp === 'json') {
			Output::error('该邮箱已被注册');
		}
		emDirect('./account.php?action=signup&error_exist=1');
	}
	if (strlen($passwd) < 6) {
		if ($resp === 'json') {
			Output::error('密码不小于6位');
		}
		emDirect('./account.php?action=signup&error_pwd_len=1');
	}
	if ($passwd !== $repasswd) {
		if ($resp === 'json') {
			Output::error('两次输入的密码不一致');
		}
		emDirect('./account.php?action=signup&error_pwd2=1');
	}

	$PHPASS = new PasswordHash(8, true);
	$passwd = $PHPASS->HashPassword($passwd);

	$User_Model->addUser('', $mail, $passwd, User::ROLE_WRITER);
	$CACHE->updateCache(['sta', 'user']);
	if ($resp === 'json') {
		Output::ok();
	}
	emDirect("./account.php?action=signin&succ_reg=1");
}

if ($action == 'send_email_code') {
	$mail = Input::postStrVar('mail');

	if (!checkMail($mail)) {
		Output::error('错误的邮箱');
	}

	$ret = Notice::sendRegMailCode($mail);
	if ($ret) {
		Output::ok();
	} else {
		Output::error('发送邮件失败');
	}
}

if ($action == 'reset') {
	if (ISLOGIN === true) {
		emDirect("../admin/");
	}

	$login_code = Option::get('login_code') === 'y';
	$error_msg = '';

	$page_title = '找回密码';
	include View::getAdmView('user_head');
	require_once View::getAdmView('reset');
	View::output();
}

if ($action == 'doreset') {
	loginAuth::checkLogged();

	$mail = isset($_POST['mail']) ? addslashes(trim($_POST['mail'])) : '';
	$login_code = isset($_POST['login_code']) ? addslashes(strtoupper(trim($_POST['login_code']))) : '';

	if (!User::checkLoginCode($login_code)) {
		emDirect('./account.php?action=reset&err_ckcode=1');
	}
	if (!$mail || !$User_Model->isMailExist($mail)) {
		emDirect('./account.php?action=reset&error_mail=1');
	}

	$ret = Notice::sendResetMailCode($mail);
	if ($ret) {
		emDirect("./account.php?action=reset2&succ_mail=1");
	} else {
		emDirect("./account.php?action=reset&error_sendmail=1");
	}
}

if ($action == 'reset2') {
	if (ISLOGIN === true) {
		emDirect("../admin/");
	}

	$login_code = Option::get('login_code') === 'y';
	$error_msg = '';

	$page_title = '找回密码';
	include View::getAdmView('user_head');
	require_once View::getAdmView('reset2');
	View::output();
}

if ($action == 'doreset2') {
	$mail_code = isset($_POST['mail_code']) ? addslashes(trim($_POST['mail_code'])) : '';
	$passwd = isset($_POST['passwd']) ? addslashes(trim($_POST['passwd'])) : '';
	$repasswd = isset($_POST['repasswd']) ? addslashes(trim($_POST['repasswd'])) : '';

	if (!$mail_code) {
		emDirect('./account.php?action=reset2&error_login=1');
	}
	if (strlen($passwd) < 6) {
		emDirect('./account.php?action=reset2&error_pwd_len=1');
	}
	if ($passwd !== $repasswd) {
		emDirect('./account.php?action=reset2&error_pwd2=1');
	}
	if (!User::checkMailCode($mail_code)) {
		emDirect('./account.php?action=reset2&err_mail_code=1');
	}

	$PHPASS = new PasswordHash(8, true);
	$passwd = $PHPASS->HashPassword($passwd);

	if (!isset($_SESSION)) {
		session_start();
	}
	$mail = isset($_SESSION['mail']) ? $_SESSION['mail'] : '';

	$User_Model->updateUserByMail(['password' => $passwd], $mail);
	emDirect("./account.php?action=signin&succ_reset=1");
}

if ($action == 'logout') {
	setcookie(AUTH_COOKIE_NAME, ' ', time() - 31536000, '/');
	emDirect("../");
}
