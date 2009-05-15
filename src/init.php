<?php
/**
 * 全局项加载
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.2.0
 * $Id: init.php 966 2009-03-06 10:00:43Z emloog $
 */

error_reporting(E_ALL);
ob_start();

require_once('config.php');
require_once(EMLOG_ROOT.'/lib/F_base.php');
require_once(EMLOG_ROOT.'/lib/F_login.php');
require_once(EMLOG_ROOT.'/lib/C_cache.php');
require_once(EMLOG_ROOT.'/lib/C_mysql.php');

header('Content-Type: text/html; charset=UTF-8');
doStripslashes();//去除多余的转义字符
//数据库操作对象
$DB = new MySql(DB_HOST, DB_USER, DB_PASSWD,DB_NAME);
//数据缓存对象
$CACHE = new mkcache($DB,DB_PREFIX);
//读取配置
$options_cache = $CACHE->readCache('options');
extract($options_cache);
$timezone  = intval($timezone);
//获取操作
$action = isset($_GET['action']) ? addslashes($_GET['action']) : '';
//获取时间
$localdate = time() - ($timezone-8) * 3600;
//登录验证
$userData = array();
define('ISLOGIN',	isLogin());
define('ROLE', ISLOGIN === true ? $userData['role'] : 'visitor');//用户组: admin管理员, writer联合撰写人, visitor访客
define('UID', ISLOGIN === true ? $userData['uid'] : '');//用户ID
//全局配置
define('TEMPLATE_PATH', EMLOG_ROOT.'/content/templates/');//前台模板路径
define('BLOG_URL', $blogurl);//博客地址
define('TEMPLATE_URL', $blogurl.'content/templates/');//前台模板目录地址
define('IMG_ATT_MAX_W',	420);//图片附件缩略图最大宽
define('IMG_ATT_MAX_H',	460);//图片附件缩略图最大高
define('ICON_MAX_W', 140);//头像缩略图最大宽
define('ICON_MAX_H', 220);//头像缩略图最大高
//加载插件
$active_plugins = unserialize($active_plugins);
$emHooks = array();
if ($active_plugins && is_array($active_plugins))
{
	foreach($active_plugins as $plugin)
	{
		if($plugin != '' && file_exists(EMLOG_ROOT . '/content/plugins/' . $plugin))
		{
			include_once(EMLOG_ROOT . '/content/plugins/' . $plugin);
		}
	}
}

?>