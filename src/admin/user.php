<?php
/**
 * 用户管理
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.1.0
 * $Id$
 */

require_once('globals.php');
require_once(EMLOG_ROOT.'/model/C_user.php');

$emUser = new emUser($DB);

//加载用户管理页面
if($action == '')
{
	$users = $emUser->getUsers();
	include getViews('header');
	require_once(getViews('user'));
	include getViews('footer');
	cleanPage();
}
if($action== 'new')
{
	$login = isset($_POST['login']) ? addslashes(trim($_POST['login'])) : '';
	$password = isset($_POST['password']) ? addslashes(trim($_POST['password'])) : '';
	$password2 = isset($_POST['password2']) ? addslashes(trim($_POST['password2'])) : '';
	$role = 'writer';//用户组：联合撰写人

	if($login == '')
	{
		header("Location: ./user.php?error_login=true");
		exit;
	}
	if(strlen($password) < 6)
	{
		header("Location: ./user.php?error_pwd_len=true");
		exit;
	}
	if($password != $password2)
	{
		header("Location: ./user.php?error_pwd2=true");
		exit;
	}
	
	require_once(EMLOG_ROOT.'/lib/C_phpass.php');
	$PHPASS = new PasswordHash(8, true);
	$password = $PHPASS->HashPassword($password);

	$emUser->addUser($login, $password, $role);

	$CACHE->mc_user();
	
	header("Location: ./user.php?active_add=true");
}
if ($action== 'edit')
{
	$uid = isset($_GET['uid']) ? intval($_GET['uid']) : '';

	$userData = $emUser->getOneUser($uid);
	extract($userData);

	include getViews('header');
	require_once(getViews('useredit'));
	include getViews('footer');cleanPage();
}
if($action=='update')
{
	$username = isset($_POST['username']) ? addslashes(trim($_POST['username'])) : '';
	$nickname = isset($_POST['nickname']) ? addslashes(trim($_POST['nickname'])) : '';
	$email = isset($_POST['email']) ? addslashes(trim($_POST['email'])) : '';
	$description = isset($_POST['description']) ? addslashes(trim($_POST['description'])) : '';
	$uid = isset($_POST['uid']) ? intval($_POST['uid']) : '';

	$emUser->updateUser(array('username'=>$username, 'nickname'=>$nickname, 'email'=>$email, 'description'=>$description), $uid);

	$CACHE->mc_user();

	header("Location: ./user.php?active_update=true");
}
if ($action== 'del')
{
	$users = $emUser->getUsers();
	$uid = isset($_GET['uid']) ? intval($_GET['uid']) : '';
	$emUser->deleteUser($uid);

	$CACHE->mc_user();

	header("Location: ./user.php?active_del=true");
}

?>