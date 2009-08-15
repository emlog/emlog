<?php
/**
 * 后台全局项加载
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.2.1
 * $Id$
 */

require_once('../init.php');

//高级配置选项
define('UPLOADFILE_MAXSIZE', 20971520);//附件大小上限 单位：字节（默认20M）
define('UPLOADFILE_PATH', '../content/uploadfile/');//附件保存目录
define('IS_THUMBNAIL', 1);//上传图片是否生成缩略图 1:是 0:否
define('ADMIN_PERPAGE_NUM', 15);//后台管理每页条目数
define('ADMIN_TPL', 'default');//后台模板名
define('TPL_PATH', EMLOG_ROOT.'/admin/views/'.ADMIN_TPL.'/');//后台当前模板路径
$att_type = array('rar','zip','gif', 'jpg', 'jpeg', 'png', 'bmp');//允许上传的文件类型

//读取缓存
$sta_cache = $CACHE->readCache('sta');
$sort_cache = $CACHE->readCache('sort');
$user_cache = $CACHE->readCache('user');
$log_cache_tags = $CACHE->readCache('log_tags');

//登录验证
if ($action == 'login')
{
	$username = isset($_POST['user']) ? addslashes(trim($_POST['user'])) : '';
	$password = isset($_POST['pw']) ? addslashes(trim($_POST['pw'])) : '';
	$ispersis = isset($_POST['ispersis']) ? intval($_POST['ispersis']) : false;
	$img_code = ($login_code == 'y' && isset($_POST['imgcode'])) ? addslashes(trim(strtoupper($_POST['imgcode']))) : '';

	if (checkUser($username, $password, $img_code, $login_code) === true)
	{
		setAuthCookie($username, $ispersis);
		header("Location: ../");
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
	formMsg('退出成功！','../',1);
}

if(ISLOGIN === false)
{
	loginpage();
}

$request_uri = strtolower(substr(basename($_SERVER['SCRIPT_NAME']), 0, -4));
if (ROLE == 'writer' && !in_array($request_uri, array('write_log','admin_log','attachment','blogger','comment','index','save_log','trackback')))
{
	formMsg('权限不足！','./', 0);
}

?>
