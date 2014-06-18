<?php
/**
 * User Management
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'globals.php';

$User_Model = new User_Model();

//Load the User Management page
if ($action == '') {
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$users = $User_Model->getUsers($page);
    $usernum = $User_Model->getUserNum();
    $pageurl =  pagination($usernum, Option::get('admin_perpage_num'), $page, "./user.php?page=");

	include View::getView('header');
	require_once View::getView('user');
	include View::getView('footer');
	View::output();
}

if ($action== 'new') {
	$login = isset($_POST['login']) ? addslashes(trim($_POST['login'])) : '';
	$password = isset($_POST['password']) ? addslashes(trim($_POST['password'])) : '';
	$password2 = isset($_POST['password2']) ? addslashes(trim($_POST['password2'])) : '';
	$role = isset($_POST['role']) ? addslashes(trim($_POST['role'])) : ROLE_WRITER;
    $ischeck = isset($_POST['ischeck']) ? addslashes(trim($_POST['ischeck'])) : 'n';

    LoginAuth::checkToken();

    if($role == ROLE_ADMIN) {
        $ischeck = 'n';
    }

	if ($login == '') {
		emDirect('./user.php?error_login=1');
	}
	if ($User_Model->isUserExist($login)) {
		emDirect('./user.php?error_exist=1');
	}
	if (mb_strlen($password) < 6) {
		emDirect('./user.php?error_pwd_len=1');
	}
	if ($password != $password2) {
		emDirect('./user.php?error_pwd2=1');
	}

	$PHPASS = new PasswordHash(8, true);
	$password = $PHPASS->HashPassword($password);

	$User_Model->addUser($login, $password, $role, $ischeck);
	$CACHE->updateCache(array('sta','user'));
	emDirect('./user.php?active_add=1');
}

if ($action== 'edit') {
	$uid = isset($_GET['uid']) ? intval($_GET['uid']) : '';

	$data = $User_Model->getOneUser($uid);
	extract($data);

	$ex1 = $ex2 = $ex3 = $ex4 = '';
	if ($role == ROLE_WRITER) {
		$ex1 = 'selected="selected"';
	} elseif ($role == ROLE_ADMIN) {
	 	$ex2 = 'selected="selected"';
	}
    if ($ischeck == 'n') {
		$ex3 = 'selected="selected"';
	} elseif ($ischeck == 'y') {
	 	$ex4 = 'selected="selected"';
	}

	include View::getView('header');
	require_once View::getView('useredit');
	include View::getView('footer');View::output();
}

if ($action=='update') {
	$login = isset($_POST['username']) ? addslashes(trim($_POST['username'])) : '';
	$nickname = isset($_POST['nickname']) ? addslashes(trim($_POST['nickname'])) : '';
	$password = isset($_POST['password']) ? addslashes(trim($_POST['password'])) : '';
	$password2 = isset($_POST['password2']) ? addslashes(trim($_POST['password2'])) : '';
	$email = isset($_POST['email']) ? addslashes(trim($_POST['email'])) : '';
	$description = isset($_POST['description']) ? addslashes(trim($_POST['description'])) : '';
	$role = isset($_POST['role']) ? addslashes(trim($_POST['role'])) : ROLE_WRITER;
	$uid = isset($_POST['uid']) ? intval($_POST['uid']) : '';
    $ischeck = isset($_POST['ischeck']) ? addslashes(trim($_POST['ischeck'])) : 'n';

    LoginAuth::checkToken();

    if($role == ROLE_ADMIN) {
        $ischeck = 'n';
    }

	if (UID == $uid) {
		emDirect('./user.php');
	}
    //Founder account can not be edited by others
    if ($uid == 1) {
		emDirect('./user.php?error_del_b=1');
	}
	if ($login == '') {
		emDirect("./user.php?action=edit&uid={$uid}&error_login=1");
	}
	if ($User_Model->isUserExist($login, $uid)) {
		emDirect("./user.php?action=edit&uid={$uid}&error_exist=1");
	}
	if (mb_strlen($password) > 0 && mb_strlen($password) < 6) {
		emDirect("./user.php?action=edit&uid={$uid}&error_pwd_len=1");
	}
	if ($password != $password2) {
		emDirect("./user.php?action=edit&uid={$uid}&error_pwd2=1");
	}

	$userData = array('username' => $login,
						'nickname' => $nickname,
						'email' => $email,
						'description' => $description,
						'role' => $role,
                        'ischeck' => $ischeck,
						);

	if (!empty($password)) {
		$PHPASS = new PasswordHash(8, true);
		$password = $PHPASS->HashPassword($password);
		$userData['password'] = $password;
	}

	$User_Model->updateUser($userData, $uid);
	$CACHE->updateCache('user');
	emDirect('./user.php?active_update=1');
}

if ($action== 'del') {
    LoginAuth::checkToken();
	$users = $User_Model->getUsers();
	$uid = isset($_GET['uid']) ? intval($_GET['uid']) : '';

	if (UID == $uid) {
		emDirect('./user.php');
	}

    //Founder account can not be deleted
    if ($uid == 1) {
		emDirect('./user.php?error_del_a=1');
	}

	$User_Model->deleteUser($uid);
	$CACHE->updateCache(array('sta','user'));
	emDirect('./user.php?active_del=1');
}
