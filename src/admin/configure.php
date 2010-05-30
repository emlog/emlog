<?php
/**
 * 基本设置
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.5.1
 * $Id$
 */

require_once 'globals.php';

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
	if($isgzipenable=='y')
	{
		$ex11="selected=\"selected\"";
		$ex12="";
	}else{
		$ex11="";
		$ex12="selected=\"selected\"";
	}
	if($isxmlrpcenable=='y')
	{
		$ex13="selected=\"selected\"";
		$ex14="";
	} else {
		$ex13="";
		$ex14="selected=\"selected\"";
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
	'login_code'   => isset($_POST['login_code']) ? addslashes($_POST['login_code']) : 'n',
	'comment_code' => isset($_POST['comment_code']) ? addslashes($_POST['comment_code']) : 'n',
	'ischkcomment' => isset($_POST['ischkcomment']) ? addslashes($_POST['ischkcomment']) : 'n',
	'isgzipenable' => isset($_POST['isgzipenable']) ? addslashes($_POST['isgzipenable']) : 'n',
	'isxmlrpcenable' => isset($_POST['isxmlrpcenable']) ? addslashes($_POST['isxmlrpcenable']) : 'n',
	'istrackback' => isset($_POST['istrackback']) ? addslashes($_POST['istrackback']) : 'n'
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
		updateOption($key, $val);
	}
	$CACHE->updateCache(array('tags', 'options', 'comment', 'record'));
	header("Location: ./configure.php?activated=true");
}
