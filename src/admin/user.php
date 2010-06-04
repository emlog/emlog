<?php
/**
 * 用户管理
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

require_once 'globals.php';
require_once EMLOG_ROOT.'/model/class.user.php';

$emUser = new emUser();

//加载用户管理页面
if ($action == '') {
	$users = $emUser->getUsers();
	include getViews('header');
	require_once getViews('user');
	include getViews('footer');
	cleanPage();
}
if ($action== 'new') {
	$login = isset($_POST['login']) ? addslashes(trim($_POST['login'])) : '';
	$password = isset($_POST['password']) ? addslashes(trim($_POST['password'])) : '';
	$password2 = isset($_POST['password2']) ? addslashes(trim($_POST['password2'])) : '';
	$role = 'writer';//用户组：联合撰写人

	if ($login == '') {
		header("Location: ./user.php?error_login=true");
		exit;
	}
	if ($emUser->isUserExist($login)) {
		header("Location: ./user.php?error_exist=true");
		exit;
	}
	if (strlen($password) < 6) {
		header("Location: ./user.php?error_pwd_len=true");
		exit;
	}
	if ($password != $password2) {
		header("Location: ./user.php?error_pwd2=true");
		exit;
	}

	require_once EMLOG_ROOT.'/lib/class.phpass.php';
	$PHPASS = new PasswordHash(8, true);
	$password = $PHPASS->HashPassword($password);

	$emUser->addUser($login, $password, $role);
	$CACHE->updateCache(array('sta','user'));
	header("Location: ./user.php?active_add=true");
}
if ($action== 'edit') {
	$uid = isset($_GET['uid']) ? intval($_GET['uid']) : '';

	$data = $emUser->getOneUser($uid);
	extract($data);

	include getViews('header');
	require_once getViews('useredit');
	include getViews('footer');cleanPage();
}
if ($action=='update') {
	$login = isset($_POST['username']) ? addslashes(trim($_POST['username'])) : '';
	$nickname = isset($_POST['nickname']) ? addslashes(trim($_POST['nickname'])) : '';
	$password = isset($_POST['password']) ? addslashes(trim($_POST['password'])) : '';
	$password2 = isset($_POST['password2']) ? addslashes(trim($_POST['password2'])) : '';
	$email = isset($_POST['email']) ? addslashes(trim($_POST['email'])) : '';
	$description = isset($_POST['description']) ? addslashes(trim($_POST['description'])) : '';
	$uid = isset($_POST['uid']) ? intval($_POST['uid']) : '';

	if ($login == '') {
		header("Location: ./user.php?action=edit&uid={$uid}&error_login=true");
		exit;
	}
	if ($emUser->isUserExist($login, $uid)) {
		header("Location: ./user.php?action=edit&uid={$uid}&error_exist=true");
		exit;
	}
	if (strlen($password) > 0 && strlen($password) < 6) {
		header("Location: ./user.php?action=edit&uid={$uid}&error_pwd_len=true");
		exit;
	}
	if ($password != $password2) {
		header("Location: ./user.php?action=edit&uid={$uid}&error_pwd2=true");
		exit;
	}

    $userData = array('username'=>$login, 
                        'nickname'=>$nickname, 
                        'email'=>$email, 
                        'description'=>$description
                        );

    if (!empty($password)) {
    	require_once EMLOG_ROOT.'/lib/class.phpass.php';
    	$PHPASS = new PasswordHash(8, true);
    	$password = $PHPASS->HashPassword($password);
        $userData['password'] = $password;
    }

	$emUser->updateUser($userData, $uid);
	$CACHE->updateCache('user');
	header("Location: ./user.php?active_update=true");
}
if ($action== 'del') {
	$users = $emUser->getUsers();
	$uid = isset($_GET['uid']) ? intval($_GET['uid']) : '';
	$emUser->deleteUser($uid);
	$CACHE->updateCache(array('sta','user'));
	header("Location: ./user.php?active_del=true");
}
