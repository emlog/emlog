<?php
/**
 * 登录验证函数库
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

/**
 * 验证用户是否处于登陆状态
 *
 * @return boolean
 */
function isLogin()
{
	global $userData;
	if( !isset($_COOKIE[AUTH_COOKIE_NAME]) )
	{
		return false;
	}
	if( ($userData = validateAuthCookie($_COOKIE[AUTH_COOKIE_NAME])) === false)
	{
		return false;
	}else {
		return true;
	}
}

/**
 * 验证密码/用户
 *
 * @param string $username
 * @param string $password
 * @param string $imgcode
 * @param string $logincode
 */
function checkUser($username,$password,$imgcode)
{
	session_start();
	if (trim($username) == '' || trim($password) == '')
	{
		return false;
	} else {
		$sessionCode = isset($_SESSION['code']) ? $_SESSION['code'] : '';
		if (Option::get('login_code') == 'y' && (empty($imgcode) || $imgcode != $sessionCode))
		{
			return false;
		}
		$userData = getUserDataByLogin($username);
		if ($userData === false){
			return false;
		}
		$hash = $userData['password'];
		$check = checkPassword($password, $hash);
		return $check;
	}
}

/**
 * 登录页面
 *
 */
function loginPage()
{
	Option::get('login_code') == 'y' ?
	$ckcode = "<span>验证码</span>
	<div class=\"val\"><input name=\"imgcode\" id=\"imgcode\" type=\"text\" />
	<img src=\"../lib/checkcode.php\" align=\"absmiddle\"></div>" :
	$ckcode = '';
	require_once View::getView('login');
	View::output();
}

/**
 * 通过登录名查询管理员信息
 *
 * @param string $userLogin User's username
 * @return bool|object False on failure, User DB row object
 */
function getUserDataByLogin($userLogin)
{
	$DB = MySql::getInstance();
	if ( empty( $userLogin ) )
	{
		return false;
	}
	$userData = false;
	if ( !$userData = $DB->once_fetch_array("SELECT * FROM ".DB_PREFIX."user WHERE username = '$userLogin'"))
	{
		return false;
	}
	$userData['nickname'] = htmlspecialchars($userData['nickname']);
	$userData['username'] = htmlspecialchars($userData['username']);
	return $userData;
}

/**
 * 将明文密码和数据库加密后的密码进行验证
 *
 * @param string $password Plaintext user's password
 * @param string $hash Hash of the user's password to check against.
 * @return bool False, if the $password does not match the hashed password
 */
function checkPassword($password, $hash)
{
	global $em_hasher;
	if ( empty($em_hasher) )
	{
		$em_hasher = new PasswordHash(8, true);
	}
	$check = $em_hasher->CheckPassword($password, $hash);
	return $check;
}

/**
 * 写用于登录验证cookie
 *
 * @param int $user_id User ID
 * @param bool $remember Whether to remember the user or not
 */
function setAuthCookie($user_login, $ispersis = false)
{
	if ( $ispersis )
	{
		$expiration  = time() + 60 * 60 * 24 * 30 * 12;
	} else {
		$expiration = null;
	}
	$auth_cookie_name = AUTH_COOKIE_NAME;
	$auth_cookie = generateAuthCookie($user_login, $expiration);
	setcookie($auth_cookie_name, $auth_cookie, $expiration,'/');
}

/**
 * 生成登录验证cookie
 *
 * @param int $user_id user login
 * @param int $expiration Cookie expiration in seconds
 * @return string Authentication cookie contents
 */
function generateAuthCookie($user_login, $expiration)
{
	$key = emHash($user_login . '|' . $expiration);
	$hash = hash_hmac('md5', $user_login . '|' . $expiration, $key);

	$cookie = $user_login . '|' . $expiration . '|' . $hash;

	return $cookie;
}

/**
 * Get hash of given string.
 *
 * @param string $data Plain text to hash
 * @return string Hash of $data
 */
function emHash($data)
{
	$key = AUTH_KEY;
	return hash_hmac('md5', $data, $key);
}

/**
 * hmac 加密
 *
 * @param unknown_type $algo hash算法 md5
 * @param unknown_type $data 用户名和到期时间
 * @param unknown_type $key
 * @return unknown
 */
if( !function_exists('hash_hmac') )
{
	function hash_hmac($algo, $data, $key)
	{
		$packs = array('md5' => 'H32', 'sha1' => 'H40');

		if ( !isset($packs[$algo]) )
		{
			return false;
		}

		$pack = $packs[$algo];

		if (strlen($key) > 64)
		{
			$key = pack($pack, $algo($key));
		}else if (strlen($key) < 64){
			$key = str_pad($key, 64, chr(0));
		}

		$ipad = (substr($key, 0, 64) ^ str_repeat(chr(0x36), 64));
		$opad = (substr($key, 0, 64) ^ str_repeat(chr(0x5C), 64));

		return $algo($opad . pack($pack, $algo($ipad . $data)));
	}
}

/**
 * 验证cookie
 * Validates authentication cookie.
 *
 * @param string $cookie Optional. If used, will validate contents instead of cookie's
 * @return bool|int False if invalid cookie, User ID if valid.
 */
function validateAuthCookie($cookie = '')
{
	if ( empty($cookie) )
	{
		return false;
	}

	$cookie_elements = explode('|', $cookie);
	if ( count($cookie_elements) != 3 )
	{
		return false;
	}

	list($username, $expiration, $hmac) = $cookie_elements;

	if ( !empty($expiration) && $expiration < time() )
	{
		return false;
	}

	$key = emHash($username . '|' . $expiration);
	$hash = hash_hmac('md5', $username . '|' . $expiration, $key);

	if ( $hmac != $hash )
	{
		return false;
	}

	$user = getUserDataByLogin($username);
	if ( ! $user )
	{
		return false;
	}

	return $user;
}
