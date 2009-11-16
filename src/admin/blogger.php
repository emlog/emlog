<?php
/**
 * 个人资料
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.4.0
 * $Id$
 */

require_once('globals.php');
require_once(EMLOG_ROOT.'/model/class.user.php');

if($action == '')
{
	$emUser = new emUser($DB);
	$row = $emUser->getOneUser(UID);
	extract($row);
	$icon = '';
	if ($photo && file_exists($photo))
	{
		$imgsize = chImageSize($photo,ICON_MAX_W,ICON_MAX_H);
		$icon = "<img src=\"{$photo}\" width=\"{$imgsize['w']}\" height=\"{$imgsize['h']}\" border=\"1\" /><a href=\"javascript: em_confirm(0, 'avatar');\">[删除头像]</a>";
	}
	include getViews('header');
	require_once(getViews('blogger'));
	include getViews('footer');
	cleanPage();
}

if($action == 'update')
{
	$emUser = new emUser($DB);
	$photo = isset($_POST['photo']) ? addslashes(trim($_POST['photo'])) : '';
	$nickname = isset($_POST['name']) ? addslashes(trim($_POST['name'])) : '';
	$email = isset($_POST['email']) ? addslashes(trim($_POST['email'])) : '';
	$description = isset($_POST['description']) ? addslashes(trim($_POST['description'])) : '';
	$photo_type = array('gif', 'jpg', 'jpeg','png');
	if($_FILES['photo']['size'] > 0)
	{
		$usericon = uploadFile($_FILES['photo']['name'], $_FILES['photo']['error'], $_FILES['photo']['tmp_name'], $_FILES['photo']['size'], $_FILES['photo']['type'], $photo_type, 1);
	}else{
		$usericon = $photo;
	}
	$emUser->updateUser(array('nickname'=>$nickname, 'email'=>$email, 'photo'=>$usericon, 'description'=>$description), UID);
	$CACHE->mc_user();
	header("Location: ./blogger.php?active_edit=true");
}

if($action == 'delicon')
{
	$query = $DB->query("select photo from ".DB_PREFIX."user");
	$icon = $DB->fetch_array($query);
	if(file_exists($icon['photo']))
	{
		$fpath = str_replace('thum-', '', $icon['photo']);
		if($fpath != $icon['photo'])
		{
			$ret = unlink($fpath);
			if(!$ret)
			{
				formMsg('头像删除失败','./blogger.php',0);
			}
		}
		$ret = unlink($icon['photo']);
		if(!$ret)
		{
			formMsg('头像删除失败','./blogger.php',0);
		}
	}
	$DB->query("UPDATE ".DB_PREFIX."user SET photo='' ");
	$CACHE->mc_user();
	header("Location: ./blogger.php?active_del=true");
}

if($action == 'update_pwd')
{
	require_once(EMLOG_ROOT.'/lib/class.phpass.php');
	
	$emUser = new emUser($DB);
	
	$login = isset($_POST['username']) ? addslashes(trim($_POST['username'])) : '';
	$newpass = isset($_POST['newpass']) ? addslashes(trim($_POST['newpass'])) : '';
	$oldpass = isset($_POST['oldpass']) ? addslashes(trim($_POST['oldpass'])) : '';
	$repeatpass = isset($_POST['repeatpass']) ? addslashes(trim($_POST['repeatpass'])) : '';
	
	$PHPASS = new PasswordHash(8, true);
	$ispass = checkPassword($oldpass, $userData['password']);

	if(!$ispass)
	{
		formMsg('错误的当前密码','javascript:history.go(-1);',0);
	}elseif(!empty($login) && $emUser->isUserExist($login, UID)){
		formMsg('用户名已存在','javascript:history.go(-1);',0);
	}elseif(strlen($newpass)>0 && strlen($newpass) < 6){
		formMsg('密码长度不得小于6位','javascript:history.go(-1);',0);
	}elseif(!empty($newpass) && $newpass != $repeatpass){
		formMsg('两次输入的密码不一致','javascript:history.go(-1);',0);
	}

	if(!empty($newpass) && empty($login))//只修改密码
	{
		$newpass = $PHPASS->HashPassword($newpass);
		$emUser->updateUser(array('password'=>$newpass), UID);
		formMsg('密码修改成功!','./',1);
	}elseif(!empty($newpass) && !empty($login))//修改密码及用户
	{
		$newpass = $PHPASS->HashPassword($newpass);
		$emUser->updateUser(array('username'=>$login, 'password'=>$newpass), UID);
		formMsg('密码和后台登录名修改成功!请重新登录','./',1);
	}elseif(empty($newpass) && !empty($login))//只修改后台登录名
	{
		$emUser->updateUser(array('username'=>$login), UID);
		formMsg('后台登录名修改成功!请重新登录','./',1);
	}else{
		formMsg('请输入要修改的项目','javascript:history.go(-1);',0);
	}
}

?>