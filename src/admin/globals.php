<?php
/**
 * Load Background Global items
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.3.0
 * $Id$
 */

require_once('../init.php');

//Advanced Configuration Options
define('UPLOADFILE_MAXSIZE', 20971520);//Attachment size limit (unit: bytes, default is 20M)
define('UPLOADFILE_PATH', '../content/uploadfile/');//Save attachments directory
define('IS_THUMBNAIL', 1);//Upload pictures is generated thumbnails 1: yes 0: No
define('ADMIN_PERPAGE_NUM', 15);//Admin number of entries per page
define('ADMIN_TPL', 'default');//Background templates were
define('TPL_PATH', EMLOG_ROOT.'/admin/views/'.ADMIN_TPL.'/');//Background current template path
$att_type = array('rar','zip','gif', 'jpg', 'jpeg', 'png', 'bmp');//Allow upload file types

//Read the Cache
$sta_cache = $CACHE->readCache('sta');
$sort_cache = $CACHE->readCache('sort');
$user_cache = $CACHE->readCache('user');
$log_cache_tags = $CACHE->readCache('log_tags');

//Login authentication
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
//Logout
if ($action == 'logout')
{
	session_start();
	session_unset();
	session_destroy();
	setcookie(AUTH_COOKIE_NAME, ' ', time() - 31536000, '/');
	formMsg($lang['logout_ok'],'../',1);
}

if(ISLOGIN === false)
{
	loginpage();
}

$request_uri = strtolower(substr(basename($_SERVER['SCRIPT_NAME']), 0, -4));
if (ROLE == 'writer' && !in_array($request_uri, array('write_log','admin_log','attachment','blogger','comment','index','save_log','trackback')))
{
	formMsg($lang['access_disabled'],'./', 0);
}
