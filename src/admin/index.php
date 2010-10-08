<?php
/**
 * 管理中心
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

require_once 'globals.php';

if ($action == '') {
	$user_cache = $CACHE->readCache('user');
    $avatar = empty($user_cache[UID]['avatar']) ? './views/' . ADMIN_TPL . '/images/avatar.jpg' : '../' . $user_cache[UID]['avatar'];
    $name =  $user_cache[UID]['name'];

    $sta_log = ROLE == 'admin' ? $sta_cache['lognum'] : $sta_cache[UID]['lognum'];
    $sta_tw = ROLE == 'admin' ? $sta_cache['twnum'] : $sta_cache[UID]['twnum'];

	$serverapp = $_SERVER['SERVER_SOFTWARE'];
	$DB = MySql::getInstance();
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

	include View::getView('header');
	require_once(View::getView('index'));
	include View::getView('footer');
	View::output();
}
//phpinfo()
if ($action == 'phpinfo') {
	@phpinfo() OR formMsg("phpinfo函数被禁用!", "javascript:history.go(-1);", 0);
}
