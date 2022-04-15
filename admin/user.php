<?php
/**
 * user
 * @package EMLOG
 * @link https://www.emlog.net
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

$User_Model = new User_Model();

if (empty($action)) {
	$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
	$email = isset($_GET['email']) ? htmlspecialchars(addslashes(trim($_GET['email']))) : '';

	$users = $User_Model->getUsers($email, $page);
	$usernum = $User_Model->getUserNum();
	$pageurl = pagination($usernum, Option::get('admin_perpage_num'), $page, "./user.php?page=");

	include View::getAdmView('header');
	require_once View::getAdmView('user');
	include View::getAdmView('footer');
	View::output();
}

if ($action == 'new') {
	$email = isset($_POST['email']) ? addslashes(trim($_POST['email'])) : '';
	$password = isset($_POST['password']) ? addslashes(trim($_POST['password'])) : '';
	$password2 = isset($_POST['password2']) ? addslashes(trim($_POST['password2'])) : '';
	$role = isset($_POST['role']) ? addslashes(trim($_POST['role'])) : self::ROLE_WRITER;

	LoginAuth::checkToken();

	if (User::isAdmin()) {
		$ischeck = 'n';
	}

	if ($email == '') {
		emDirect('./user.php?error_email=1');
	}
	if ($User_Model->isMailExist($email)) {
		emDirect("./user.php?error_exist_email=1");
	}
	if (strlen($password) < 6) {
		emDirect('./user.php?error_pwd_len=1');
	}
	if ($password != $password2) {
		emDirect('./user.php?error_pwd2=1');
	}

	$PHPASS = new PasswordHash(8, true);
	$password = $PHPASS->HashPassword($password);

	$User_Model->addUser('', $email, $password, $role);
	$CACHE->updateCache(array('sta', 'user'));
	emDirect('./user.php?active_add=1');
}

if ($action == 'edit') {
	$uid = isset($_GET['uid']) ? (int)$_GET['uid'] : '';

	$data = $User_Model->getOneUser($uid);
	extract($data);

	$ex1 = $ex2 = $ex3 = $ex4 = '';
	if ($role == User::ROLE_WRITER) {
		$ex1 = 'selected="selected"';
	} elseif (User::isAdmin()) {
		$ex2 = 'selected="selected"';
	}
	if ($ischeck == 'n') {
		$ex3 = 'selected="selected"';
	} elseif ($ischeck == 'y') {
		$ex4 = 'selected="selected"';
	}

	include View::getAdmView('header');
	require_once View::getAdmView('user_edit');
	include View::getAdmView('footer');
	View::output();
}

if ($action == 'update') {
	$login = isset($_POST['username']) ? addslashes(trim($_POST['username'])) : '';
	$nickname = isset($_POST['nickname']) ? addslashes(trim($_POST['nickname'])) : '';
	$password = isset($_POST['password']) ? addslashes(trim($_POST['password'])) : '';
	$password2 = isset($_POST['password2']) ? addslashes(trim($_POST['password2'])) : '';
	$email = isset($_POST['email']) ? addslashes(trim($_POST['email'])) : '';
	$description = isset($_POST['description']) ? addslashes(trim($_POST['description'])) : '';
	$role = isset($_POST['role']) ? addslashes(trim($_POST['role'])) : User::ROLE_WRITER;
	$uid = isset($_POST['uid']) ? (int)$_POST['uid'] : '';

	LoginAuth::checkToken();

	if (UID == $uid) {
		emDirect('./user.php');
	}
	//创始人账户不能被他人编辑
	if ($uid == 1) {
		emDirect('./user.php?error_del_b=1');
	}
	if (empty($nickname)) {
		emDirect("./user.php?action=edit&uid={$uid}&error_nickname=1");
	}
	if (empty($email)) {
		emDirect("./user.php?action=edit&uid={$uid}&error_email=1");
	}
	if ($User_Model->isMailExist($email, $uid)) {
		emDirect("./user.php?action=edit&uid={$uid}&error_exist_email=1");
	}
	if ($User_Model->isUserExist($login, $uid)) {
		emDirect("./user.php?action=edit&uid={$uid}&error_exist=1");
	}
	if (strlen($password) > 0 && strlen($password) < 6) {
		emDirect("./user.php?action=edit&uid={$uid}&error_pwd_len=1");
	}
	if ($password != $password2) {
		emDirect("./user.php?action=edit&uid={$uid}&error_pwd2=1");
	}

	$userData = [
		'username'    => $login,
		'nickname'    => $nickname,
		'email'       => $email,
		'description' => $description,
		'role'        => $role,
	];

	if (!empty($password)) {
		$PHPASS = new PasswordHash(8, true);
		$password = $PHPASS->HashPassword($password);
		$userData['password'] = $password;
	}

	$User_Model->updateUser($userData, $uid);
	$CACHE->updateCache('user');
	emDirect('./user.php?active_update=1');
}

if ($action == 'del') {
	LoginAuth::checkToken();
	$uid = isset($_GET['uid']) ? (int)$_GET['uid'] : '';

	if (UID == $uid) {
		emDirect('./user.php');
	}

	//创始人账户不能被删除
	if ($uid == 1) {
		emDirect('./user.php?error_del_a=1');
	}

	$User_Model->deleteUser($uid);
	$CACHE->updateCache(array('sta', 'user'));
	emDirect('./user.php?active_del=1');
}
