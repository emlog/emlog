<?php
/**
 * Load Global Items
 * @package EMLOG (www.emlog.net)
 */

error_reporting(E_ALL);
ob_start();
header('Content-Type: text/html; charset=UTF-8');

/*vot*/ define('EMLOG_ROOT', str_replace('\\', '/', __DIR__));

if (extension_loaded('mbstring')) {
	mb_internal_encoding('UTF-8');
}

require_once EMLOG_ROOT . '/config.php';
require_once EMLOG_ROOT . '/include/lib/function.base.php';

spl_autoload_register("emAutoload");

$CACHE = Cache::getInstance();

$userData = array();

define('ISLOGIN', LoginAuth::isLogin());

//Site Time Zone
date_default_timezone_set(Option::get('timezone'));

//User Groups: admin=Administrator, writer=Co-Author, visitor=Guest
const ROLE_ADMIN = 'admin';
const ROLE_WRITER = 'writer';
const ROLE_VISITOR = 'visitor';
//User Roles
define('ROLE', ISLOGIN === true ? $userData['role'] : ROLE_VISITOR);
//User ID
define('UID', ISLOGIN === true ? $userData['uid'] : '');
//Site fixed address
define('BLOG_URL', Option::get('blogurl'));
//Template Library URL
const TPLS_URL = BLOG_URL . 'content/templates/';
//Template Library Path
const TPLS_PATH = EMLOG_ROOT . '/content/templates/';
//Resolve the front domain for ajax
define('DYNAMIC_BLOGURL', Option::get("blogurl"));
//Front template URL
define('TEMPLATE_URL', TPLS_URL . Option::get('nonce_templet') . '/');
//Access Scheme
/*vot*/define('SCHEME', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://');
/*vot*/define('ROOT_URL', str_replace('\\','/', dirname($_SERVER['PHP_SELF'])));

$active_plugins = Option::get('active_plugins');
$emHooks = array();
if ($active_plugins && is_array($active_plugins)) {
	foreach ($active_plugins as $plugin) {
		if (true === checkPlugin($plugin)) {
			include_once(EMLOG_ROOT . '/content/plugins/' . $plugin);
		}
	}
}
