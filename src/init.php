<?php
/**
 * 全局项加载
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

error_reporting(E_ALL);
ob_start();
header('Content-Type: text/html; charset=UTF-8');

define('EMLOG_ROOT', dirname(__FILE__));

require_once EMLOG_ROOT.'/config.php';
require_once EMLOG_ROOT.'/include/lib/function.base.php';
require_once EMLOG_ROOT.'/include/lib/function.login.php';

doStripslashes();

$CACHE = Cache::getInstance();

$userData = array();

define('ISLOGIN',	isLogin());
//用户组: admin管理员, writer联合撰写人, visitor访客
define('ROLE', ISLOGIN === true ? $userData['role'] : 'visitor');
//用户ID
define('UID', ISLOGIN === true ? $userData['uid'] : '');
//博客固定地址
define('BLOG_URL', Option::get('blogurl'));
//模板库地址
define('TPLS_URL', BLOG_URL.'content/templates/');
//模板库路径
define('TPLS_PATH', EMLOG_ROOT.'/content/templates/');
//解决前台多域名ajax跨域
define('DYNAMIC_BLOGURL', getBlogUrl());
//前台模板URL
define('TEMPLATE_URL', 	TPLS_URL.Option::get('nonce_templet').'/');

$active_plugins = Option::get('active_plugins');
$emHooks = array();
if ($active_plugins && is_array($active_plugins)) {
	foreach($active_plugins as $plugin) {
		if(true === checkPlugin($plugin)) {
			include_once(EMLOG_ROOT . '/content/plugins/' . $plugin);
		}
	}
}
