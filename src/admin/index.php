<?php
/**
 * 管理中心
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'globals.php';

if ($action == '') {
	$avatar = empty($user_cache[UID]['avatar']) ? './views/images/avatar.jpg' : '../' . $user_cache[UID]['avatar'];
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
			$gd_ver = '支持';
		}
	} else{
		$gd_ver = '不支持';
	}

	include View::getView('header');
	require_once(View::getView('index'));
	include View::getView('footer');
	View::output();
}
if ($action == 'update' && ROLE == ROLE_ADMIN) {
	$source = isset($_GET['source']) ? trim($_GET['source']) : '';
	$upsql = isset($_GET['upsql']) ? trim($_GET['upsql']) : '';

	if (empty($source)) {
		exit('error');
	}

	$temp_file = emFecthFile(OFFICIAL_SERVICE_HOST . $source);
	if (!$temp_file) {
		 exit('error_down');
	}

	$ret = emUnZip($temp_file, '../', 'update');
	@unlink($temp_file);

	switch ($ret) {
		case 1:
		case 2:
			exit('error_dir');
			break;
		case 3:
			exit('error_zip');
			break;
	}

	//update db
	if(!$upsql) {
		exit('succ');
	}
	$DB = Database::getInstance();
	$setchar = $DB->getMysqlVersion() > '4.1' ? "ALTER DATABASE `" . DB_NAME . "` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;" : '';
	$temp_file = emFecthFile(OFFICIAL_SERVICE_HOST . $upsql);
	if (!$temp_file) {
		 exit('error_down');
	}
	$sql = file($temp_file);
	@unlink($temp_file);
	array_unshift($sql,$setchar);
	$query = '';
	foreach ($sql as $value) {
		if (!$value || $value[0]=='#') {
			continue;
		}
		$value = str_replace("{db_prefix}", DB_PREFIX, trim($value));
		if (preg_match("/\;$/i", $value)) {
			$query .= $value;
			$DB->query($query);
			$query = '';
		} else{
			$query .= $value;
		}
	}
	$CACHE->updateCache();
	exit('succ');
}