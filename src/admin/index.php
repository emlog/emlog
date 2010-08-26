<?php
/**
 * Admin Center
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

require_once 'globals.php';

if ($action == '') {
    $avatar = empty($user_cache[UID]['avatar']) ? './views/' . ADMIN_TPL . '/images/avatar.jpg' : '../' . $user_cache[UID]['avatar'];
    $name =  $user_cache[UID]['name'];

    $sta_log = ROLE == 'admin' ? $sta_cache['lognum'] : $sta_cache[UID]['lognum'];
    $sta_tw = ROLE == 'admin' ? $sta_cache['twnum'] : $sta_cache[UID]['twnum'];

	$serverapp = $_SERVER['SERVER_SOFTWARE'];
	$mysql_ver = $DB->getMysqlVersion();
	$php_ver = PHP_VERSION;
	$uploadfile_maxsize = ini_get('upload_max_filesize');
	$safe_mode = ini_get('safe_mode');

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
if ($action == 'phpinfo') {
	@phpinfo() OR formMsg($lang['phpinfo_disabled'], "javascript:history.go(-1);", 0);
}
