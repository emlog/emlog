<?php
/**
 * 个人资料
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.7.0
 * $Id$
 */

require_once('./globals.php');

if($action == '')
{
	include getViews('header');

	$result = $DB->query("select * from {$db_prefix}user");
	$row=$DB->fetch_array($result);
	extract($row);
	$name = htmlspecialchars($nickname);
	$email = htmlspecialchars($email);
	$photo = htmlspecialchars(trim($photo));
	$bloggerdes = htmlspecialchars($description);

	require_once(getViews('blogger'));
	include getViews('footer');cleanPage();
}

//修改个人资料
if($action== 'modintro')
{
	$flg = isset($_GET['flg']) ? intval($_GET['flg']) : 0;
	if(!$flg)
	{
		$photo = isset($_POST['photo']) ? addslashes(trim($_POST['photo'])) : '';
		$nickname = isset($_POST['name']) ? addslashes(trim($_POST['name'])) : '';
		$mail = isset($_POST['mail']) ? addslashes(trim($_POST['mail'])) : '';
		$description = isset($_POST['description']) ? addslashes(trim($_POST['description'])) : '';
	
		$photo_type = array('gif', 'jpg', 'jpeg','png');
		if($_FILES['photo']['size']>0)
		{
			$usericon = uploadFile($_FILES['photo']['name'],$_FILES['photo']['tmp_name'],$_FILES['photo']['size'],$photo_type,$_FILES['photo']['type'],1);
		}else
		{
			$usericon = $photo;
		}
		$sql="UPDATE {$db_prefix}user SET nickname='$nickname',email='$mail',photo='$usericon',description='$description'";
		$DB->query($sql);
		$MC->mc_blogger('../cache/blogger');
		formMsg( "个人资料修改成功","./blogger.php",1);
	}else 
	{
		$description = isset($_POST['bdes']) ? addslashes(trim($_POST['bdes'])) : '';
		$sql="UPDATE {$db_prefix}user SET description='$description' ";
		$DB->query($sql);
		$MC->mc_blogger('../cache/blogger');
		echo $description;
	}
}

//删除头像
if($action== 'delicon')
{
	//删除头像文件
	$query=$DB->query("select photo from {$db_prefix}user");
	$icon=$DB->fetch_array($query);
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
	//删除数据库记录
	$DB->query("UPDATE {$db_prefix}user SET photo='' ");
	$MC->mc_blogger('../cache/blogger');
	formMsg('头像成功删除','./blogger.php',1);
}

//修改用户名密码
if($action=='update_admin')
{
	$user=isset($_POST['username'])?addslashes(trim($_POST['username'])):'';
	$newpass=isset($_POST['newpass'])?addslashes(trim($_POST['newpass'])) : '';
	$oldpass=isset($_POST['oldpass'])?md5(addslashes(trim($_POST['oldpass']))):'';
	$repeatpass=isset($_POST['repeatpass'])?addslashes(trim($_POST['repeatpass'])):'';

	$ispass = checkPass($oldpass);

	//只修改密码
	if(strlen($newpass)>=6 && $newpass==$repeatpass && $ispass && strlen($user)==0){
		$sql=" UPDATE {$db_prefix}user SET password='".md5($newpass)."' ";
		$DB->query($sql);
		formMsg('密码已修改!请重新登录','./index.php',1);
	}
	//修改密码及用户
	if(strlen($newpass)>=6 && $newpass==$repeatpass && $ispass && strlen($user)!=0){
		$sql=" UPDATE {$db_prefix}user SET
			username='".$user."',
			password='".md5($newpass)."' ";
		$DB->query($sql);
		formMsg('密码和用户名已修改!请重新登录','./index.php',1);
	}
	//只修改用户
	if(strlen($user)!=0 && strlen($newpass)==0 && $ispass){
		$sql=" UPDATE {$db_prefix}user SET username='".$user."' ";
		$DB->query($sql);
		formMsg('用户名已修改!请重新登录','./index.php',1);
	}
	//错误处理
	if(!$ispass)
	formMsg('错误的当前密码','javascript:history.go(-1);',0);
	elseif($newpass!=$repeatpass)
	formMsg('两次输入的密码不一致','javascript:history.go(-1);',0);
	elseif(strlen($newpass)>0 && strlen($newpass) < 6)
	formMsg('密码长度不得小于6位','javascript:history.go(-1);',0);
	else
	formMsg('请输入修改项目参数','javascript:history.go(-1);',0);
}

?>