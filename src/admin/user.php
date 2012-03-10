<?php
/**
 * 用户管理
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'globals.php';

$User_Model = new User_Model();

//加载用户管理页面
if ($action == '') {
	$users = $User_Model->getUsers();
	include View::getView('header');
	require_once View::getView('user');
	include View::getView('footer');
	View::output();
}

if ($action== 'new') {
	$login = isset($_POST['login']) ? addslashes(trim($_POST['login'])) : '';
	$password = isset($_POST['password']) ? addslashes(trim($_POST['password'])) : '';
	$password2 = isset($_POST['password2']) ? addslashes(trim($_POST['password2'])) : '';
	$role = isset($_POST['role']) ? addslashes(trim($_POST['role'])) : 'writer';

	if ($login == '') {
		emDirect('./user.php?error_login=true');
	}
	if ($User_Model->isUserExist($login)) {
		emDirect('./user.php?error_exist=true');
	}
	if (strlen($password) < 6) {
		emDirect('./user.php?error_pwd_len=true');
	}
	if ($password != $password2) {
		emDirect('./user.php?error_pwd2=true');
	}

	$PHPASS = new PasswordHash(8, true);
	$password = $PHPASS->HashPassword($password);

	$User_Model->addUser($login, $password, $role);
	$CACHE->updateCache(array('sta','user'));
	emDirect('./user.php?active_add=true');
}

if ($action== 'edit') {
	$uid = isset($_GET['uid']) ? intval($_GET['uid']) : '';

	$data = $User_Model->getOneUser($uid);
	extract($data);

	$ex1 = $ex2 = '';
	if ($role == 'writer') {
		$ex1 = 'selected="selected"';
	} elseif($role == 'admin') {
	 	$ex2 = 'selected="selected"';
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
	$role = isset($_POST['role']) ? addslashes(trim($_POST['role'])) : 'writer';
	$uid = isset($_POST['uid']) ? intval($_POST['uid']) : '';

	if (UID == $uid) {
		emDirect('./user.php');
	}
	if ($login == '') {
		emDirect("./user.php?action=edit&uid={$uid}&error_login=true");
	}
	if ($User_Model->isUserExist($login, $uid)) {
		emDirect("./user.php?action=edit&uid={$uid}&error_exist=true");
	}
	if (strlen($password) > 0 && strlen($password) < 6) {
		emDirect("./user.php?action=edit&uid={$uid}&error_pwd_len=true");
	}
	if ($password != $password2) {
		emDirect("./user.php?action=edit&uid={$uid}&error_pwd2=true");
	}

    $userData = array('username' => $login,
                        'nickname' => $nickname,
                        'email' => $email,
                        'description' => $description,
    					'role' => $role,
                        );

    if (!empty($password)) {
    	$PHPASS = new PasswordHash(8, true);
    	$password = $PHPASS->HashPassword($password);
        $userData['password'] = $password;
    }

	$User_Model->updateUser($userData, $uid);
	$CACHE->updateCache('user');
	emDirect('./user.php?active_update=true');
}

if ($action== 'del') {
	$users = $User_Model->getUsers();
	$uid = isset($_GET['uid']) ? intval($_GET['uid']) : '';

	if (UID == $uid) {
		emDirect('./user.php');
	}

	$User_Model->deleteUser($uid);
	$CACHE->updateCache(array('sta','user'));
	emDirect('./user.php?active_del=true');
}
