<?php
/**
 * 管理中心
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.6.0
 */

require_once('./globals.php');

if ($action == '')
{
	include getViews('header');
	require_once('../cache/sta');
	
	extract($sta_cache);
	
	$serverapp = $_SERVER['SERVER_SOFTWARE'];
	$mysql_ver = $DB->version();
	$php_ver = PHP_VERSION;
	$serverdate = date('Y-n-d G:i:s',time());

	if (function_exists("imagecreate"))
	{
		if(function_exists('gd_info'))
		{
			$ver_info = gd_info();
			$gd_ver = $ver_info['GD Version'];
		}else{
			$gd_ver = '支持';
		}
	}else
	{
		$gd_ver = '不支持GD图形库';
	}
	
	require_once(getViews('index'));
	include getViews('footer');
	cleanPage();
}
?>