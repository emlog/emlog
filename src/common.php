<?php
/**
 * 前端全局项加载主程序
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.6.5
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
require_once(EMLOG_ROOT.'/cache/config');
require_once(EMLOG_ROOT.'/cache/log_tags');
require_once(EMLOG_ROOT.'/cache/log_atts');
require_once(EMLOG_ROOT.'/cache/tags');
require_once(EMLOG_ROOT.'/cache/comments');
require_once(EMLOG_ROOT.'/cache/links');
require_once(EMLOG_ROOT.'/cache/blogger');
require_once(EMLOG_ROOT.'/cache/records');
require_once(EMLOG_ROOT.'/cache/sta');
require_once(EMLOG_ROOT.'/cache/musics');
require_once(EMLOG_ROOT.'/cache/twitter');

//去除多余的转义字符
doStripslashes();
//数据库操作对象
$DB = new MySql($host, $user, $pass,$db);
//是否登录状态
define('ISLOGIN',	isLogin());
//获取操作
$action = isset($_GET['action'])?addslashes($_GET['action']):'';
//config
	$sitekey	= $config_cache['sitekey'];
	$blogtitle  = $config_cache['blogname'];
	$blogname	= $config_cache['blogname'];
	$blog_info  = $config_cache['bloginfo'];
	$icp        = $config_cache['icp'];
	$index_lognum	    = $config_cache['index_lognum'];
	$index_comment_num	= $config_cache['index_comment_num'];
	$index_tagnum   = $config_cache['index_tagnum'];
	$index_twnum   = $config_cache['index_twnum'];
	$comment_code	= $config_cache['comment_code'];
	$login_code	    = $config_cache['login_code'];
	$ischkcomment      = $config_cache['ischkcomment'];
	$isurlrewrite   = $config_cache['isurlrewrite'];
	$istrackback   = $config_cache['istrackback'];
	$comment_subnum = $config_cache['comment_subnum'];
	$nonce_tpl = $config_cache['nonce_templet'];
	$blogurl   = $config_cache['blogurl'];
	$exarea    = $config_cache['exarea'];
	$timezone  = intval($config_cache['timezone']);
	$tpl_dir   = './templates/';//所有模板存放目录
	$timezone != 8 ? $localdate = time() - ($timezone-8) * 3600 : $localdate = time();
	isset($tag_cache)?sort($tag_cache):$tag_cache = array();

//decode comment
if(isset($com_cache))
{
	foreach($com_cache as $key=>$value)
	{
		$com_cache[$key]['name'] = base64_decode($com_cache[$key]['name']);
		$com_cache[$key]['content'] = base64_decode($com_cache[$key]['content']);
	}
}else{
	$com_cache = array();
}

//cache 
$MC = new mkcache($DB,$db_prefix);

//site info
$icp = $icp;
$photo = $user_cache['photo'];
$blogger_des = $user_cache['des'];
$user_cache['mail']!=''?
$name = "<a href=\"mailto:".$user_cache['mail']."\">".$user_cache['name']."</a>":
$name = $user_cache['name'];

//music
if($ismusic)
{
	$key = $randplay?mt_rand(0,count($mlinks)-1):0;
	$music = $mlinks[$key];
	$musicdes = !empty($mdes[$key])?"{$mdes[$key]}<br>":'';
	$autoplay = $auto?"&autoplay=1":'';
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