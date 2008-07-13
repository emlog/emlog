<?php
/**
 * 前端全局项加载主程序
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.7.0
 * $Id$
 */

error_reporting(E_ALL);
ob_start();

//$start_time=array_sum(explode(' ',microtime()));

define('EMLOG_ROOT', dirname(__FILE__));

require_once(EMLOG_ROOT.'/config.php');
require_once(EMLOG_ROOT.'/lib/C_mysql.php');
require_once(EMLOG_ROOT.'/lib/F_base.php');
require_once(EMLOG_ROOT.'/lib/F_login.php');
require_once(EMLOG_ROOT.'/lib/C_cache.php');

//数据库操作对象
$DB = new MySql($host, $user, $pass,$db);
//cache
$MC = new mkcache($DB,$db_prefix);
//去除多余的转义字符
doStripslashes();
//登录验证
define('ISLOGIN',	isLogin());
//获取操作
$action = isset($_GET['action'])?addslashes($_GET['action']):'';

//读取缓存
$config_cache = $MC->readCache(EMLOG_ROOT.'/cache/config');
$log_cache_tags = $MC->readCache(EMLOG_ROOT.'/cache/log_tags');
$log_cache_atts = $MC->readCache(EMLOG_ROOT.'/cache/log_atts');
$tag_cache = $MC->readCache(EMLOG_ROOT.'/cache/tags');
$com_cache = $MC->readCache(EMLOG_ROOT.'/cache/comments');
$link_cache = $MC->readCache(EMLOG_ROOT.'/cache/links');
$user_cache = $MC->readCache(EMLOG_ROOT.'/cache/blogger');
$dang_cache = $MC->readCache(EMLOG_ROOT.'/cache/records');
$sta_cache = $MC->readCache(EMLOG_ROOT.'/cache/sta');
$tw_cache = $MC->readCache(EMLOG_ROOT.'/cache/twitter');
$music = $MC->readCache(EMLOG_ROOT.'/cache/musics');

//配置项目
extract($config_cache);
$exarea    = stripslashes($exarea);
$timezone  = intval($timezone);
$tpl_dir   = './templates/';//所有模板存放目录
$localdate = $timezone != 8 ? time() - ($timezone-8) * 3600 : time();

//站点信息
$icp = $icp;
$photo = $user_cache['photo'];
$blogger_des = $user_cache['des'];
$user_cache['mail']!=''?
$name = "<a href=\"mailto:".$user_cache['mail']."\">".$user_cache['name']."</a>":
$name = $user_cache['name'];

//背景音乐
if($ismusic = $music['ismusic'])
{
	$key = $music['randplay']?mt_rand(0,count($music['mlinks'])-1):0;
	$musicurl = $music['mlinks'][$key];
	$musicdes = !empty($music['mdes'][$key])?$music['mdes'][$key].'<br>':'';
	$autoplay = $music['auto']?"&autoplay=1":'';
}

//登陆验证
if ($action == 'login')
{
	session_start();
	$username = addslashes(trim($_POST['user']));
	$password = md5(addslashes(trim($_POST['pw'])));
	$login_code == 'y'?$img_code = addslashes(trim(strtoupper($_POST['imgcode']))):$img_code = '';
	if (strlen($username) >16)
	{
		header("Location: index.php");
	}
	if (checkUser($username, $password,$img_code,$login_code))
	{
		if (function_exists('session_regenerate_id'))//PHP_VERSION >= '4.3.2'
		{
			session_regenerate_id();
		}
		$_SESSION['adminname'] = $username;
		$_SESSION['password'] = $password;
		header("Location: index.php");
	}else
	{
		header("Location: index.php");
	}
}
//登出
if ($action == 'logout')
{
	session_start();
	session_unset();
	session_destroy();
	header("Location: index.php");
}
?>