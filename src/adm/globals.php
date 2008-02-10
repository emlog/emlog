<?php
/**
 * 后台全局项加载主程序
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.6.0
 */

error_reporting(E_ALL);
//header('Content-Type: text/html; charset=UTF-8');
ob_start();

require_once('../config.php');
require_once('../lib/F_base.php');
require_once('../lib/F_adm.php');
require_once('../lib/C_mysql.php');
require_once('./tips.php');		
require_once('../lib/C_cache.php');

//去除多余的转义字符
doStripslashes();
//获取GET变量
$action = isset($_GET['action'])?$_GET['action']:'';
//数据库操作对象
$DB = new MySql($host, $user, $pass,$db);
		
//读取配置参数
$show_config = $DB->fetch_array($DB->query("SELECT * FROM ".$db_prefix."config"));
$dftnum = $DB->num_rows($DB->query("SELECT gid FROM ".$db_prefix."blog WHERE hide='y'"));
//配置参数
$login_code = $show_config['login_code'];
$comment_code = $show_config['comment_code'];
$ischkcomment = $show_config['ischkcomment'];
$isurlrewrite   = $show_config['isurlrewrite'];
$nonce_templet = $show_config['nonce_templet'];
$index_comment_num = $show_config['index_comnum'];
$index_tagnum = $show_config['index_tagnum'];
$comment_subnum = $show_config['comment_subnum'];
$blogurl = $show_config['blogurl'];
$blogname = $show_config['blogname'];
$timezone = intval($show_config['timezone']);
$draftnum = $dftnum>0 ? "($dftnum)" : '';//草稿数目
$tips = getTips($tips);//加载小提示
$att_type = array('rar','zip','gif', 'jpg', 'jpeg', 'png','bmp');//允许上传的文件类型
$edition = '2.6.0';				//版本号
$uploadroot = "../uploadfile/";	//附件保存目录
$tpl_dir = '../templates/';		//所有模板目录
$nonce_tpl = 'default';			//后台模板 adm/views/default

define('IMG_ATT_MAX_W',		420);//图片附件缩略图最大宽
define('IMG_ATT_MAX_H',		460);//图片附件缩略图最大高
define('ICON_MAX_W',		140);//个性头像缩略图最大宽
define('ICON_MAX_H',		220);//个性头像缩略图最大高

//检测后台模板
define('ADM_ROOT', dirname(__FILE__));
$em_tpldir = ADM_ROOT.'/views/'.$nonce_tpl.'/';
if (!is_dir($em_tpldir))
{
	exit('the adm tmplate net found!');
}
//实例化一个缓存生成对象
$MC = new mkcache($host, $user, $pass,$db,$db_prefix);
unset($host, $user, $pass,$db);

//登陆验证
if ($action == 'login') 
{
	session_start();
	$username = addslashes(trim($_POST['user']));
	$password = md5(addslashes(trim($_POST['pw'])));
	$login_code == 'y'?$img_code = addslashes(trim(strtoupper($_POST['imgcode']))):$img_code = '';
	if (strlen($username) >16) 
	{
		formMsg('ERROR!!','javascript:history.go(-1);',0);
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
		loginPage();
	}
}
//登出
if ($action == 'logout')
{
	session_start();
	session_unset();
	session_destroy();
	formMsg('退出成功！','../index.php',1);
}

isLogin();//验证用户是否处于登陆状态

?>