<?php
/**
 * 博客设置
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.1.0
 * $Id$
 */

require_once('globals.php');

if ($action == '')
{
	if($login_code=='y')
	{
		$ex1="selected=\"selected\"";
		$ex2="";
	}else{
		$ex1="";
		$ex2="selected=\"selected\"";
	}
	if($comment_code=='y')
	{
		$ex3="selected=\"selected\"";
		$ex4="";
	}else{
		$ex3="";
		$ex4="selected=\"selected\"";
	}
	if($ischkcomment=='y')
	{
		$ex5="selected=\"selected\"";
		$ex6="";
	}else{
		$ex5="";
		$ex6="selected=\"selected\"";
	}
	if($istrackback=='y')
	{
		$ex7="selected=\"selected\"";
		$ex8="";
	}else{
		$ex7="";
		$ex8="selected=\"selected\"";
	}
	if($isurlrewrite=='y')
	{
		$ex9="selected=\"selected\"";
		$ex10="";
	}else{
		$ex9="";
		$ex10="selected=\"selected\"";
	}
	if($isgzipenable=='y')
	{
		$ex11="selected=\"selected\"";
		$ex12="";
	}else{
		$ex11="";
		$ex12="selected=\"selected\"";
	}

	include getViews('header');
	require_once(getViews('configure'));
	include getViews('footer');
	cleanPage();
}

//update config
if ($action == "mod_config")
{
	$getData = array(
	'site_key' => isset($_POST['site_key']) ? addslashes($_POST['site_key']) : '',
	'blogname' => isset($_POST['blogname']) ? addslashes($_POST['blogname'])  : '',
	'blogurl' => isset($_POST['blogurl']) ? addslashes($_POST['blogurl']) : '',
	'bloginfo' => isset($_POST['bloginfo']) ? addslashes($_POST['bloginfo']) : '',
	'icp' => isset($_POST['icp']) ? addslashes($_POST['icp']):'',
	'index_lognum' => isset($_POST['index_lognum']) ? intval($_POST['index_lognum']) : '',
	'timezone' => isset($_POST['timezone']) ? floatval($_POST['timezone']) : '',
	'login_code'   => isset($_POST['login_code']) ? $_POST['login_code'] : 'n',
	'comment_code' => isset($_POST['comment_code']) ? $_POST['comment_code'] : 'n',
	'ischkcomment' => isset($_POST['ischkcomment']) ? $_POST['ischkcomment'] : 'n',
	'isurlrewrite' => isset($_POST['isurlrewrite']) ? $_POST['isurlrewrite'] : 'n',
	'isgzipenable' => isset($_POST['isgzipenable']) ? $_POST['isgzipenable'] : 'n',
	'istrackback' => isset($_POST['istrackback']) ? $_POST['istrackback'] : 'n',
	);

	if ($getData['login_code']=='y' && !function_exists("imagecreate") && !function_exists('imagepng'))
	{
		formMsg("开启登录验证码失败!服务器不支持该功能","configure.php",0);
	}
	if ($getData['comment_code']=='y' && !function_exists("imagecreate") && !function_exists('imagepng'))
	{
		formMsg("开启评论验证码失败!服务器不支持该功能","configure.php",0);
	}

	if($getData['blogurl'] && substr($getData['blogurl'], -1) != '/')
	{
		$getData['blogurl'] .= '/';
	}
	if($getData['blogurl'] && strncasecmp($getData['blogurl'],'http://',7))//0 if they are equal
	{
		$getData['blogurl'] = 'http://'.$getData['blogurl'];
	}

	foreach ($getData as $key => $val)
	{
		$DB->query("UPDATE ".DB_PREFIX."options SET option_value='$val' where option_name='$key'");
	}
	$CACHE->mc_tags();
	$CACHE->mc_comment();
	$CACHE->mc_options();
	$CACHE->mc_record();
	$CACHE->mc_twitter();
	header("Location: ./configure.php?activated=true");
}
//phpinfo()
if ($action == 'phpinfo')
{
	@phpinfo() OR die('phpinfo函数被禁用!');
}
?>