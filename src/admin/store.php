<?php
/**
 * 应用中心
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'globals.php';

if ($action == '') {
	$site_url_encode = rawurlencode(base64_encode(BLOG_URL));
	include View::getView('header');
	require_once(View::getView('store'));
	include View::getView('footer');
	View::output();
}

if ($action == 'instpl') {
	$source = isset($_GET['source']) ? trim($_GET['source']) : '';
	$source_type = 'tpl';
	$source_typename = '模板';
	$source_typeurl = '<a href="template.php">查看模板</a>';
	include View::getView('header');
	require_once(View::getView('store_install'));
	include View::getView('footer');
}

if ($action == 'insplu') {
	$source = isset($_GET['source']) ? trim($_GET['source']) : '';
	$source_type = 'plu';
	$source_typename = '插件';
	$source_typeurl = '<a href="plugin.php">查看插件</a>';
	include View::getView('header');
	require_once(View::getView('store_install'));
	include View::getView('footer');  
}

if ($action == 'addon') {
	LoginAuth::checkToken();
	$source = isset($_GET['source']) ? trim($_GET['source']) : '';
	$source_type = isset($_GET['type']) ? trim($_GET['type']) : '';
	if (empty($source)) {
		exit('error');
	}

	$temp_file = emFecthFile(OFFICIAL_SERVICE_HOST . $source);
	if (!$temp_file) {
		 exit('error_down');
	}

	$unzip_path = $source_type == 'tpl' ? '../content/templates/' : '../content/plugins/';
	$ret = emUnZip($temp_file, $unzip_path, $source_type);
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
