<?php
/**
 * 后台全局项加载
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.1.0
 * $Id$
 */

require_once('../init.php');

//高级配置选项
define('TEMPLATE_PATCH', '../content/templates/');//模板目录
define('ADMIN_TPL', 			'default');//后台模板
define('UPLOADFILE_MAXSIZE',	20971520);//附件大小上限 单位：字节（默认20M）
define('UPLOADFILE_PATH',		'../content/uploadfile/');//附件保存目录
define('IS_THUMBNAIL',			1);//上传图片是否生成缩略图 1:是 0:否
define('IMG_ATT_MAX_W',			420);//图片附件缩略图最大宽
define('IMG_ATT_MAX_H',			460);//图片附件缩略图最大高
define('ICON_MAX_W',			140);//个性头像缩略图最大宽
define('ICON_MAX_H',			220);//个性头像缩略图最大高
$att_type = array('rar','zip','gif', 'jpg', 'jpeg', 'png', 'bmp');//允许上传的文件类型

//检测后台模板
define('ADMIN_ROOT', dirname(__FILE__));
$em_tpldir = ADMIN_ROOT.'/views/'.ADMIN_TPL.'/';
if (!is_dir($em_tpldir))
{
	exit('the adm tmplate net found!');
}
//读取统计信息
$sta_cache = $CACHE->readCache('sta');
$sort_cache = $CACHE->readCache('sort');
$user_cache = $CACHE->readCache('user');

//登陆验证
if ($action == 'login')
{
	$username = isset($_POST['user']) ? addslashes(trim($_POST['user'])) : '';
	$password = isset($_POST['pw']) ? addslashes(trim($_POST['pw'])) : '';
	$ispersis = isset($_POST['ispersis']) ? intval($_POST['ispersis']) : false;
	$img_code = ($login_code == 'y' && isset($_POST['imgcode'])) ? addslashes(trim(strtoupper($_POST['imgcode']))) : '';

	if (checkUser($username, $password, $img_code, $login_code) === true)
	{
		setAuthCookie($username, $ispersis);
		header("Location: ../index.php");
	}else{
		loginPage();
	}
}
//登出
if ($action == 'logout')
{
	session_start();
	session_unset();
	session_destroy();
	setcookie(AUTH_COOKIE_NAME, ' ', time() - 31536000, '/');
	formMsg('退出成功！','../index.php',1);
}

$userData = array();
if(isLogin() === false)
{
	loginpage();
}

define('ROLE', $userData['role']);	//用户组 'admin'：管理员 'writer':联合撰稿人
define('UID', $userData['uid']);	//用户ID

$request_uri = substr(basename($_SERVER['SCRIPT_NAME']), 0, -4);
if (ROLE == 'writer' && !in_array($request_uri, array('write_log','admin_log','attachment','blogger','comment','index','save_log','trackback')))
{
	formMsg('权限不足！','./index.php', 0);
}

?>
