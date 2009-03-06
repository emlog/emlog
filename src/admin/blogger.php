<?php
/**
 * 个人资料
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.1.0
 * $Id$
 */

require_once('./globals.php');

if($action == '')
{
	include getViews('header');

	$result = $DB->query("select * from ".DB_PREFIX."user");
	$row=$DB->fetch_array($result);
	extract($row);
	$name = htmlspecialchars($nickname);
	$email = htmlspecialchars($email);
	$photo = htmlspecialchars(trim($photo));
	$bloggerdes = htmlspecialchars($description);

	require_once(getViews('blogger'));
	include getViews('footer');cleanPage();
}

if($action == 'modintro')
{
	$flg = isset($_GET['flg']) ? intval($_GET['flg']) : 0;
	if(!$flg)
	{
		$photo = isset($_POST['photo']) ? addslashes(trim($_POST['photo'])) : '';
		$nickname = isset($_POST['name']) ? addslashes(trim($_POST['name'])) : '';
		$mail = isset($_POST['mail']) ? addslashes(trim($_POST['mail'])) : '';
		$description = isset($_POST['description']) ? addslashes(trim($_POST['description'])) : '';
	
		$photo_type = array('gif', 'jpg', 'jpeg','png');
		if($_FILES['photo']['size'] > 0)
		{
			$usericon = uploadFile($_FILES['photo']['name'],$_FILES['photo']['tmp_name'],$_FILES['photo']['size'],$photo_type,$_FILES['photo']['type'],1);
		}else{
			$usericon = $photo;
		}
		$sql="UPDATE ".DB_PREFIX."user SET nickname='$nickname',email='$mail',photo='$usericon',description='$description'";
		$DB->query($sql);
		$CACHE->mc_blogger();
		header("Location: ./blogger.php?active_edit=true");
	}else {
		$description = isset($_POST['bdes']) ? addslashes(trim($_POST['bdes'])) : '';
		$DB->query("UPDATE ".DB_PREFIX."user SET description='$description'");
		$CACHE->mc_blogger();
		echo $description;
	}
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
	$CACHE->mc_blogger();
	header("Location: ./blogger.php?active_del=true");
}

if($action == 'update_admin')
{
	require_once(EMLOG_ROOT.'/lib/C_phpass.php');
	
	$user = isset($_POST['username']) ? addslashes(trim($_POST['username'])) : '';
	$newpass = isset($_POST['newpass']) ? addslashes(trim($_POST['newpass'])) : '';
	$oldpass = isset($_POST['oldpass']) ? addslashes(trim($_POST['oldpass'])) : '';
	$repeatpass = isset($_POST['repeatpass']) ? addslashes(trim($_POST['repeatpass'])) : '';
	
	$PHPASS = new PasswordHash(8, true);
	$ispass = checkPassword($oldpass, $userData['password']);

	//只修改密码
	if(strlen($newpass)>=6 && $newpass==$repeatpass && $ispass && strlen($user)==0)
	{
		$newpass = $PHPASS->HashPassword($newpass);
		$DB->query(" UPDATE ".DB_PREFIX."user SET password='$newpass'");
		formMsg('密码修改成功!','./index.php',1);
	}
	//修改密码及用户
	if(strlen($newpass)>=6 && $newpass==$repeatpass && $ispass && strlen($user)!=0)
	{
		$newpass = $PHPASS->HashPassword($newpass);
		$DB->query("UPDATE ".DB_PREFIX."user SET username='$user',password='$newpass'");
		formMsg('密码和后台登录名修改成功!请重新登录','./index.php',1);
	}
	//只修改后台登录名
	if(strlen($user)!=0 && strlen($newpass)==0 && $ispass)
	{
		$sql=" UPDATE ".DB_PREFIX."user SET username='$user'";
		$DB->query($sql);
		formMsg('后台登录名修改成功!请重新登录','./index.php',1);
	}
	//错误处理
	if(!$ispass)
	{
		formMsg('错误的当前密码','javascript:history.go(-1);',0);
	}elseif($newpass != $repeatpass){
		formMsg('两次输入的密码不一致','javascript:history.go(-1);',0);
	}elseif(strlen($newpass)>0 && strlen($newpass) < 6){
		formMsg('密码长度不得小于6位','javascript:history.go(-1);',0);
	}else{
		formMsg('请输入修改项目参数','javascript:history.go(-1);',0);
	}
}

?>