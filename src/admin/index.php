<?php
/**
 * Admin Center
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'globals.php';

if ($action == '') {
	$avatar = empty($user_cache[UID]['avatar']) ? './views/images/avatar.svg' : '../' . $user_cache[UID]['avatar'];
	$name =  $user_cache[UID]['name'];

	$serverapp = $_SERVER['SERVER_SOFTWARE'];
	$DB = Database::getInstance();
	$mysql_ver = $DB->getMysqlVersion();
	$php_ver = PHP_VERSION;
	$uploadfile_maxsize = ini_get('upload_max_filesize');
	$safe_mode = ini_get('safe_mode');

	if (function_exists("imagecreate")) {
		if (function_exists('gd_info')) {
			$ver_info = gd_info();
			$gd_ver = $ver_info['GD Version'];
		} else{
/*vot*/            $gd_ver = lang('supported');
		}
	} else{
/*vot*/        $gd_ver = lang('not_supported');
	}

	include View::getView('header');
	require_once(View::getView('index'));
	include View::getView('footer');
	View::output();
}