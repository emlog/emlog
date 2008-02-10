<?php
/**
 * 前端全局项加载主程序
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.6.0
 */

error_reporting(E_ALL);
ob_start();

//$start_time=array_sum(explode(' ',microtime()));

require_once('./config.php');
require_once('./lib/F_base.php');
require_once('./lib/C_mysql.php');
require_once('./lib/C_cache.php');
require_once('./cache/config');
require_once('./cache/log_tags');
require_once('./cache/log_atts');
require_once('./cache/tags');
require_once('./cache/comments');
require_once('./cache/links');
require_once('./cache/blogger');
require_once('./cache/records');
require_once('./cache/sta');
require_once('./cache/musics');

//去除多余的转义字符
doStripslashes();
//数据库操作对象
$DB = new MySql($host, $user, $pass,$db);

//config
	$sitekey	= $config_cache['sitekey'];
	$blogtitle  = $config_cache['blogname'];
	$blogname	= $config_cache['blogname'];
	$blog_info  = $config_cache['bloginfo'];
	$icp        = $config_cache['icp'];
	$index_lognum	    = $config_cache['index_lognum'];
	$index_comment_num	= $config_cache['index_comment_num'];
	$index_tagnum   = $config_cache['index_tagnum'];
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
	define('EMLOG_ROOT', dirname(__FILE__));

//check template
$em_tpldir = $tpl_dir.$nonce_tpl.'/';//当前模板目录
if (!is_dir($em_tpldir))
{
	exit('Template Error: no template directory!');
}
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
$MC = new mkcache($host, $user, $pass,$db,$db_prefix);
unset($host, $user, $pass,$db);

if($comment_code == 'y')
{
	session_cache_limiter('private, must-revalidate');
	session_start();
}
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
	$randindex = mt_rand(0,count($mlinks)-1);
	$music = $randplay?$mlinks[$randindex]:$mlinks[0];
	$autoplay = $auto?"&autoplay=1":'';
}
//view count
$em_viewip = isset($_COOKIE['em_viewip'])?$_COOKIE['em_viewip']:'';
if ($em_viewip !== getIp())
{
	setcookie ('em_viewip', getIp(), $localdate+(6*3600));
	$curtime = date("Y-m-d");
	$rs = $DB->fetch_one_array("SELECT curdate FROM ".$db_prefix."statistics WHERE curdate='".$curtime."'");
	if(!$rs)
	{
		$DB->query("UPDATE ".$db_prefix."statistics SET curdate ='".$curtime."'");
		$DB->query("UPDATE ".$db_prefix."statistics SET day_view_count = '1'");
	} else
	{
		$DB->query("UPDATE ".$db_prefix."statistics SET day_view_count = day_view_count+1");
	}
	$DB->query("UPDATE ".$db_prefix."statistics SET view_count = view_count+1");
	$MC->mc_sta('./cache/sta');
}
	
?>
