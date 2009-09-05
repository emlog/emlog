<?php
/**
 * Load Global Items
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.3.0
 * $Id: init.php 966 2009-03-06 10:00:43Z emloog $
 */

error_reporting(E_ALL);
ob_start();

/*vot*/mb_internal_encoding('UTF-8');

define('EMLOG_ROOT', dirname(__FILE__));

require_once(EMLOG_ROOT.'/config.php');
/*vot*/ require_once(EMLOG_ROOT.'/lang/'.EMLOG_LANGUAGE.'.php');
require_once(EMLOG_ROOT.'/lib/F_base.php');
require_once(EMLOG_ROOT.'/lib/F_login.php');
require_once(EMLOG_ROOT.'/lib/C_cache.php');
require_once(EMLOG_ROOT.'/lib/C_mysql.php');

header('Content-Type: text/html; charset=UTF-8');
doStripslashes();
$DB = new MySql(DB_HOST, DB_USER, DB_PASSWD,DB_NAME);
$CACHE = new mkcache($DB,DB_PREFIX);

//Read Configuration
$options_cache = $CACHE->readCache('options');
extract($options_cache);
$timezone  = intval($timezone);

//Get Action
$action = isset($_GET['action']) ? addslashes($_GET['action']) : '';

//Capture the Time
$localdate = time() - ($timezone - 8) * 3600;

//Login Authentication
$userData = array();
define('ISLOGIN',	isLogin());
define('ROLE', ISLOGIN === true ? $userData['role'] : 'visitor');//User Group: admin=administrator, writer=co-writer, visitor=visitors
define('UID', ISLOGIN === true ? $userData['uid'] : '');//User ID

//Global Configuration
define('BLOG_URL', $blogurl);//Blog URL
define('TEMPLATE_PATH', 'content/templates/');//Foreground template path
define('IMG_ATT_MAX_W',	420);//Thumbnail image attachment maximum width
define('IMG_ATT_MAX_H',	460);//Thumbnail image Maximum height
define('ICON_MAX_W', 140);//Icon image Maximum width
define('ICON_MAX_H', 220);//Icon image Maximum height          
define('EMLOG_VERSION','3.3.0');

//Load plug-ins
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
