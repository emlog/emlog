<?php
/**
 * init.
 * @package EMLOG
 * @link https://www.emlog.net
 */

if (getenv('EMLOG_ENV') === 'develop') {
	error_reporting(E_ALL);
} else {
	error_reporting(1);
}

ob_start();
header('Content-Type: text/html; charset=UTF-8');

const EMLOG_ROOT = __DIR__;

if (extension_loaded('mbstring')) {
	mb_internal_encoding('UTF-8');
}

require_once EMLOG_ROOT . '/config.php';
require_once EMLOG_ROOT . '/include/lib/common.php';

spl_autoload_register("emAutoload");

$CACHE = Cache::getInstance();

$userData = [];

define('ISLOGIN', LoginAuth::isLogin());
date_default_timezone_set(Option::get('timezone'));

const ROLE_ADMIN = 'admin';
const ROLE_EDITOR = 'editor';
const ROLE_WRITER = 'writer';
const ROLE_VISITOR = 'visitor';

define('ROLE', ISLOGIN === true ? $userData['role'] : User::ROLE_VISITOR);
define('UID', ISLOGIN === true ? $userData['uid'] : '');
//站点固定地址
define('BLOG_URL', Option::get('blogurl'));
//模板库地址
const TPLS_URL = BLOG_URL . 'content/templates/';
//模板库路径
const TPLS_PATH = EMLOG_ROOT . '/content/templates/';
//解决前台多域名ajax跨域
define('DYNAMIC_BLOGURL', Option::get("blogurl"));
define('TEMPLATE_URL', TPLS_URL . Option::get('nonce_templet') . '/');
const ADMIN_TEMPLATE_PATH = EMLOG_ROOT . '/admin/views/';

const MSGCODE_EMKEY_INVALID = 1001;
const MSGCODE_NO_UPUPDATE = 1002;
const MSGCODE_SUCCESS = 200;

$active_plugins = Option::get('active_plugins');
$emHooks = [];
if ($active_plugins && is_array($active_plugins)) {
	foreach ($active_plugins as $plugin) {
		if (true === checkPlugin($plugin)) {
			include_once(EMLOG_ROOT . '/content/plugins/' . $plugin);
		}
	}
}
