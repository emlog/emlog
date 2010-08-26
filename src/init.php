<?php
/**
 * Load Global Items
 * @copyright (c) Emlog All Rights Reserved
 * $Id: init.php 966 2009-03-06 10:00:43Z emloog $
 */

error_reporting(E_ALL);
ob_start();

/*vot*/mb_internal_encoding('UTF-8');

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
//Read Configuration
$options_cache = $CACHE->readCache('options');
extract($options_cache);

//Get Action
$action = isset($_GET['action']) ? addslashes($_GET['action']) : '';
$utctimestamp = time();


//Login Authentication
$userData = array();
define('ISLOGIN',	isLogin());
define('ROLE', ISLOGIN === true ? $userData['role'] : 'visitor');//User Group: admin=administrator, writer=co-writer, visitor=visitors
define('UID', ISLOGIN === true ? $userData['uid'] : '');//User ID

//Global Configuration
define('BLOG_URL', $blogurl);//Blog URL
define('TPLS_URL', 		$blogurl.'content/templates/');//Template gallery URL
define('TPLS_PATH', 	EMLOG_ROOT.'/content/templates/');//Template gallery path
define('DYNAMIC_BLOGURL', getBlogUrl());//Solve the frontend multi-domain ajax queries

define('ICON_MAX_H', 220);//Icon image Maximum height          
//Load plug-ins
$active_plugins = unserialize($active_plugins);
$emHooks = array();
if ($active_plugins && is_array($active_plugins)) {
	foreach($active_plugins as $plugin) {
		if(true === checkPlugin($plugin)) {
			include_once(EMLOG_ROOT . '/content/plugins/' . $plugin);
		}
	}
}
