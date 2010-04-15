<?php
/**
 * 管理中心
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.5.0
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
			$gd_ver = '支持';
		}
	}else{
		$gd_ver = '不支持';
	}

	include getViews('header');
	require_once(getViews('index'));
	include getViews('footer');
	cleanPage();
}
//phpinfo()
if ($action == 'phpinfo') {
	@phpinfo() OR formMsg("phpinfo函数被禁用!", "javascript:history.go(-1);", 0);
}
