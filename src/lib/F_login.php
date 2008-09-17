<?php
/**
 * 登录验证函数库
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.7.0
 * $Id$
 */

/**
 * 验证用户是否处于登陆状态
 *
 * @return boolean
 */
function isLogin()
{
	session_cache_limiter('private, must-revalidate');
	session_start();
	global $DB,$db_prefix;
	if (isset($_SESSION['adminname']) && isset($_SESSION['password']) && $_SESSION['adminname'] !='' && $_SESSION['password'] !='')
	{
		$SQL = "SELECT password FROM {$db_prefix}user  WHERE username='". $_SESSION['adminname'] ."' AND password = '".$_SESSION['password']."' ";
		$result = $DB->query($SQL);
		$getpass = $DB->fetch_array($result);
		if ($getpass['password'] != $_SESSION['password']) 
		{
			return FALSE;
		}
	} else {
		return FALSE;
	}
	return TRUE;
}

/**
 * 验证密码/用户
 *
 * @param unknown_type $username
 * @param unknown_type $password
 * @param unknown_type $imgcode
 * @param unknown_type $logincode
 * @return boolean
 */
function checkUser($username,$password,$imgcode,$logincode)
{
	global $DB,$userinfo,$db_prefix;
	if (trim($username) == '' || trim($username) == '')
	{
		return FALSE;
	} else {	
		$userinfo = $DB->fetch_one_array("SELECT * FROM {$db_prefix}user WHERE username = '$username' AND password='$password' ");
		if (empty($userinfo))
		{
			return FALSE;
		} elseif ($logincode == 'y' && $imgcode != $_SESSION['code']) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
}

/**
 * 验证密码(修改密码用)
 *
 * @param string $password 当前密码
 * @return unknown
 */
function checkPass($password)
{
	global $DB,$db_prefix;
	$query = $DB->query("select * from {$db_prefix}user where password = '$password'");
	$ispass = $DB->fetch_array($query);
	if (empty($ispass))
	{
		return false;
	}else{
		return true;
	}
}

/**
 * 登录页面
 *
 */
function loginPage() 
{
	global $login_code,$nonce_tpl;
	$login_code == 'y' ?
	$ckcode = "<tr><td >验证码:<br /><input type=\"hidden\" name=\"action\" value=\"login\" >
				<input name=\"imgcode\" type=\"text\" class=\"INPUT\" size=\"5\">&nbsp&nbsp\n
				<img src=\"../lib/C_checkcode.php\" align=\"absmiddle\"></td></tr>\n" :
	$ckcode = '';
	require_once(getViews('login'));
	cleanPage();
	exit;
}