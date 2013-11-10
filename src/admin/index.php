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
	$DB = MySql::getInstance();
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
if ($action == 'update') {
    $source = isset($_GET['source']) ? trim($_GET['source']) : '';
    if (empty($source)) {
        exit('error');
    }
	$temp_file = tempnam('/tmp', 'emtemp_');
    $rh = fopen($source, 'rb');
    $wh = fopen($temp_file, 'w+b');
    if ( ! $rh || ! $wh) {
        exit('error_down');
    }

    while (!feof($rh)) {
        if (fwrite($wh, fread($rh, 4096)) === FALSE) {
            exit('error_down');
        }
    }

    fclose($rh);
    fclose($wh);	

    $unzip_path = '../';
	$ret = emUnZip($temp_file, $unzip_path, 'update');
    @unlink($temp_file);
    switch ($ret) {
		case 0:
			exit('succ');
			break;
		case 1:
		case 2:
			exit('error_dir');
			break;
		case 3:
			exit('error_zip');
			break;
	}
}
//phpinfo()
if ($action == 'phpinfo') {
	@phpinfo() OR emMsg("phpinfo函数被禁用!");
}
