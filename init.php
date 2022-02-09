<?php
/**
 * 全局项加载
 * @package EMLOG (www.emlog.net)
 */

error_reporting(E_ALL);
ob_start();
header('Content-Type: text/html; charset=UTF-8');

const EMLOG_ROOT = __DIR__;

if (extension_loaded('mbstring')) {
	mb_internal_encoding('UTF-8');
}

require_once EMLOG_ROOT . '/config.php';
require_once EMLOG_ROOT . '/include/lib/function.base.php';

spl_autoload_register("emAutoload");

$CACHE = Cache::getInstance();

$userData = [];

define('ISLOGIN', LoginAuth::isLogin());

//站点时区
date_default_timezone_set(Option::get('timezone'));

//用户组
const ROLE_ADMIN = 'admin';              //管理员
const ROLE_WRITER = 'writer';            //用户
const ROLE_VISITOR = 'visitor';          //游客

//用户组
define('ROLE', ISLOGIN === true ? $userData['role'] : User::ROLE_VISITOR);
//用户ID
define('UID', ISLOGIN === true ? $userData['uid'] : '');
//站点固定地址
define('BLOG_URL', Option::get('blogurl'));
//模板库地址
const TPLS_URL = BLOG_URL . 'content/templates/';
//模板库路径
const TPLS_PATH = EMLOG_ROOT . '/content/templates/';
//解决前台多域名ajax跨域
define('DYNAMIC_BLOGURL', Option::get("blogurl"));
//前台模板URL
define('TEMPLATE_URL', TPLS_URL . Option::get('nonce_templet') . '/');
//后台模板路径
const ADMIN_TEMPLATE_PATH = EMLOG_ROOT . '/admin/views/';
//官方服务域名
const OFFICIAL_SERVICE_HOST = 'https://www.emlog.net/';
//错误码
const MSGCODE_EMKEY_INVALID = 1001;      // 错误的注册码
const MSGCODE_NO_UPUPDATE = 1002;        // 没有可用的版本更新
const MSGCODE_SUCCESS = 200;             // 成功

$active_plugins = Option::get('active_plugins');
$emHooks = [];
if ($active_plugins && is_array($active_plugins)) {
	foreach ($active_plugins as $plugin) {
		if (true === checkPlugin($plugin)) {
			include_once(EMLOG_ROOT . '/content/plugins/' . $plugin);
		}
	}
}
