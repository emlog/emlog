<?php
/**
 * store
 * @package EMLOG
 * @link https://www.emlog.net
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

$Store_Model = new Store_Model();

if (empty($action)) {
	$tag = isset($_GET['tag']) ? addslashes($_GET['tag']) : '';
	$keyword = isset($_GET['keyword']) ? addslashes($_GET['keyword']) : '';
	$templates = $Store_Model->getTemplates($tag, $keyword);
	$sub_title = '模板' . ($tag === 'free' ? '免费区' : '付费区');

	include View::getAdmView('header');
	require_once(View::getAdmView('store_tpl'));
	include View::getAdmView('footer');
	View::output();
}

if ($action === 'plu') {
	$tag = isset($_GET['tag']) ? addslashes($_GET['tag']) : '';
	$keyword = isset($_GET['keyword']) ? addslashes($_GET['keyword']) : '';
	$plugins = $Store_Model->getPlugins($tag, $keyword);
	$sub_title = '插件' . ($tag === 'free' ? '免费区' : '付费区');

	include View::getAdmView('header');
	require_once(View::getAdmView('store_plu'));
	include View::getAdmView('footer');
	View::output();
}

if ($action === 'error') {
	include View::getAdmView('header');
	require_once(View::getAdmView('store_tpl'));
	include View::getAdmView('footer');
	View::output();
}

if ($action === 'install') {
	$source = isset($_GET['source']) ? trim($_GET['source']) : '';
	$source_type = isset($_GET['type']) ? trim($_GET['type']) : '';

	if (!Register::isRegLocal()) {
		emDirect("./auth.php?error_store=1");
	}

	if (empty($source)) {
		emDirect("./store.php?error_param=1");
	}

	$temp_file = emFetchFile('https://www.emlog.net/' . $source);
	if (!$temp_file) {
		emDirect("./store.php?error_down=1");
	}

	if ($source_type == 'tpl') {
		$unzip_path = '../content/templates/';
		$store_path = './store.php?';
	} else {
		$unzip_path = '../content/plugins/';
		$store_path = './store.php?action=plu&';
	}

	$ret = emUnZip($temp_file, $unzip_path, $source_type);
	@unlink($temp_file);
	switch ($ret) {
		case 0:
			emDirect($store_path . 'active=1');
		case 1:
		case 2:
			emDirect($store_path . 'error_dir=1');
		case 3:
			emDirect($store_path . 'error_zip=1');
		default:
			emDirect($store_path . 'error_source=1');
	}
}
