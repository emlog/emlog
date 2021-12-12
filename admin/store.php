<?php
/**
 * links
 * @package EMLOG (www.emlog.net)
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

$Store_Model = new Store_Model();

if (empty($action)) {
	$templates = $Store_Model->getTemplates();

	include View::getView('header');
	require_once(View::getView('store_tpl'));
	include View::getView('footer');
	View::output();
}

if ($action === 'plu') {
	$plugins = $Store_Model->getPlugins();

	include View::getView('header');
	require_once(View::getView('store_plu'));
	include View::getView('footer');
	View::output();
}

if ($action === 'error') {
	include View::getView('header');
	require_once(View::getView('store_tpl'));
	include View::getView('footer');
	View::output();
}

if ($action === 'install') {
	$source = isset($_GET['source']) ? trim($_GET['source']) : '';
	$source_type = isset($_GET['type']) ? trim($_GET['type']) : '';
	if (empty($source)) {
		emDirect("./store.php?error_param=1");
	}

	$temp_file = emFetchFile(OFFICIAL_SERVICE_HOST . $source);
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
