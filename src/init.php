<?php
require_once dirname(__FILE__).'/../_ToDo/my_func.php';
/**
 * Load Global Items
 * @copyright (c) Emlog All Rights Reserved
 */

error_reporting(E_ALL);
ob_start();
header('Content-Type: text/html; charset=UTF-8');

define('EMLOG_ROOT', str_replace('\\', '/', dirname(__FILE__)));

/*vot*/mb_internal_encoding('UTF-8');

require_once EMLOG_ROOT.'/config.php';

require_once EMLOG_ROOT.'/include/lib/function.base.php';

///*vot*/ require_once(EMLOG_ROOT.'/lang/'.EMLOG_LANGUAGE.'/lang_all.php');
// Load the core Lang File
/*vot*/ load_lang('all');

doStripslashes();

$CACHE = Cache::getInstance();

$userData = array();

define('ISLOGIN',	LoginAuth::isLogin());

//User role: admin = administrator, writer = co-author, visitor = guest
define('ROLE_ADMIN', 'admin');
define('ROLE_WRITER', 'writer');
define('ROLE_VISITOR', 'visitor');
//User role
define('ROLE', ISLOGIN === true ? $userData['role'] : ROLE_VISITOR);
//User ID
define('UID', ISLOGIN === true ? $userData['uid'] : '');
//Blog URL
define('BLOG_URL', Option::get('blogurl'));
//Template folder URL
define('TPLS_URL', BLOG_URL.'content/templates/');
//Template folder path
define('TPLS_PATH', EMLOG_ROOT.'/content/templates/');
//Solve the frontend multi-domain ajax queries
define('DYNAMIC_BLOGURL', getBlogUrl());
//Front-end template URL
define('TEMPLATE_URL', 	TPLS_URL.Option::get('nonce_templet').'/');

//Load plug-ins
$active_plugins = Option::get('active_plugins');
$emHooks = array();
if ($active_plugins && is_array($active_plugins)) {
	foreach($active_plugins as $plugin) {
		if(true === checkPlugin($plugin)) {
			include_once(EMLOG_ROOT . '/content/plugins/' . $plugin);
		}
	}
}
