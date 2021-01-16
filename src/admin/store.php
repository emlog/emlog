<?php
/**
 * Application Center
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'globals.php';

if ($action == '') {
/*vot*/ $site_url_encode = rawurlencode(base64_encode(rtrim(BLOG_URL, '/')));
/*vot*/ $site_url_encode = preg_replace('/%3D/', '', $site_url_encode);
 	include View::getView('header');
	require_once(View::getView('store'));
	include View::getView('footer');
	View::output();
}

if ($action == 'instpl') {
	$source = isset($_GET['source']) ? trim($_GET['source']) : '';
	$source_type = 'tpl';
/*vot*/ $source_typename = lang('template');
/*vot*/ $source_typeurl = '<a href="template.php">'.lang('template_view').'</a>';
	include View::getView('header');
	require_once(View::getView('store_install'));
	include View::getView('footer');
}

if ($action == 'insplu') {
	$source = isset($_GET['source']) ? trim($_GET['source']) : '';
	$source_type = 'plu';
/*vot*/ $source_typename = lang('plugin');
/*vot*/ $source_typeurl = '<a href="plugin.php">'.lang('plugin_view').'</a>';
	include View::getView('header');
	require_once(View::getView('store_install'));
	include View::getView('footer');  
}

if ($action == 'addon') {
	$source = isset($_GET['source']) ? trim($_GET['source'],"/") : '';
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
