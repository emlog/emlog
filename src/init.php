<?php
/**
 * 全局项加载
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.4.0
 * $Id: init.php 966 2009-03-06 10:00:43Z emloog $
 */

error_reporting(E_ALL);
ob_start();

require_once 'options.php';
require_once EMLOG_ROOT.'/config.php';
require_once EMLOG_ROOT.'/lib/function.base.php';
require_once EMLOG_ROOT.'/lib/function.login.php';
require_once EMLOG_ROOT.'/lib/class.cache.php';
require_once EMLOG_ROOT.'/lib/class.mysql.php';

header('Content-Type: text/html; charset=UTF-8');
doStripslashes();
$DB = MySql::getInstance();
$CACHE = mkcache::getInstance();
$options_cache = $CACHE->readCache('options');
extract($options_cache);

$action = isset($_GET['action']) ? addslashes($_GET['action']) : '';
$utctimestamp = time();

$userData = array();
define('ISLOGIN',	isLogin());
define('ROLE', ISLOGIN === true ? $userData['role'] : 'visitor');//用户组: admin管理员, writer联合撰写人, visitor访客
define('UID', ISLOGIN === true ? $userData['uid'] : '');//用户ID
define('BLOG_URL', 		$blogurl);//博客固定地址
define('TPLS_URL', 		$blogurl.'content/templates/');//模板库地址
define('TPLS_PATH', 	EMLOG_ROOT.'/content/templates/');//模板库路径
define('DYNAMIC_BLOGURL', getBlogUrl());//解决前台多域名ajax跨域

$active_plugins = unserialize($active_plugins);
$emHooks = array();
if ($active_plugins && is_array($active_plugins))
{
	foreach($active_plugins as $plugin)
	{
		if(preg_match("/^[\w\-\/]+\.php$/", $plugin) && file_exists(EMLOG_ROOT . '/content/plugins/' . $plugin))
		{
			include_once(EMLOG_ROOT . '/content/plugins/' . $plugin);
		}
	}
}
