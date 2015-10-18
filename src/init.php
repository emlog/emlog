<?php
/**
 * Load Global Items
 * @copyright (c) Emlog All Rights Reserved
 */

error_reporting(E_ALL);
ob_start();
header('Content-Type: text/html; charset=UTF-8');

/*vot*/ define('EMLOG_ROOT', str_replace('\\','/',dirname(__FILE__)));

if (extension_loaded('mbstring')) {
	mb_internal_encoding('UTF-8');
}

require_once EMLOG_ROOT.'/config.php';
require_once EMLOG_ROOT.'/include/lib/function.base.php';

doStripslashes();

$CACHE = Cache::getInstance();

$userData = array();

define('ISLOGIN',	LoginAuth::isLogin());

//Site Time Zone
date_default_timezone_set(Option::get('timezone'));

//User Groups: admin=Administrator, writer=Co-Author, visitor=Guest
define('ROLE_ADMIN', 'admin');
define('ROLE_WRITER', 'writer');
define('ROLE_VISITOR', 'visitor');
//User Roles
define('ROLE', ISLOGIN === true ? $userData['role'] : ROLE_VISITOR);
//User ID
define('UID', ISLOGIN === true ? $userData['uid'] : '');
//Site fixed address
define('BLOG_URL', Option::get('blogurl'));
//Template Library URL
define('TPLS_URL', BLOG_URL.'content/templates/');
//Template Library Path
define('TPLS_PATH', EMLOG_ROOT.'/content/templates/');
//Resolve the front domain for ajax
define('DYNAMIC_BLOGURL', Option::get("blogurl"));
//Front template URL
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
