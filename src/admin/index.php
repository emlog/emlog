<?php
/**
 * 管理中心
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.3.0
 * $Id$
 */

require_once('globals.php');

if ($action == '')
{
	$serverapp = $_SERVER['SERVER_SOFTWARE'];
	$mysql_ver = $DB->getMysqlVersion();
	$php_ver = PHP_VERSION;
	$uploadfile_maxsize = ini_get('upload_max_filesize');
	$safe_mode = ini_get('safe_mode');
	$serverdate = date('Y-n-d G:i:s',time());

	if (function_exists("imagecreate"))
	{
		if(function_exists('gd_info'))
		{
			$ver_info = gd_info();
			$gd_ver = $ver_info['GD Version'];
		}else{
			$gd_ver = $lang['supported'];
		}
	}else{
		$gd_ver = $lang['not_supported'];
	}

	include getViews('header');
	require_once(getViews('index'));
	include getViews('footer');
	cleanPage();
}
//phpinfo()
if ($action == 'phpinfo')
{
	@phpinfo() OR formMsg($lang['phpinfo_disabled'], "javascript:history.go(-1);", 0);
}

?>
