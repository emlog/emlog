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

if (empty($action)) {
	$emcurl = new EmCurl();
	$emcurl->setPost(['emkey' => Option::get('emkey'), 'ver' => Option::EMLOG_VERSION, 'type' => 'tpl']);
	$emcurl->request(OFFICIAL_SERVICE_HOST . 'store/pro');
	$retStatus = $emcurl->getHttpStatus();
	if ($retStatus !== MSGCODE_SUCCESS) {
		emDirect("./store.php?action=error&error=1");
	}
	$response = $emcurl->getRespone();
	$ret = json_decode($response, 1);
	if (empty($ret)) {
		emDirect("./store.php?action=error&error=1");
	}
	if ($ret['code'] === MSGCODE_EMKEY_INVALID) {
		Option::updateOption('emkey', '');
		$CACHE->updateCache('options');
		emDirect("./register.php?error_store=1");
	}

	$templates = $ret['data']['templates'] ?? [];

	include View::getView('header');
	require_once(View::getView('store_tpl'));
	include View::getView('footer');
	View::output();
}

if ($action === 'plu') {
	$emcurl = new EmCurl();
	$emcurl->setPost(['emkey' => Option::get('emkey'), 'ver' => Option::EMLOG_VERSION, 'type' => 'plu']);
	$emcurl->request(OFFICIAL_SERVICE_HOST . 'store/pro');
	$retStatus = $emcurl->getHttpStatus();
	if ($retStatus !== MSGCODE_SUCCESS) {
		emDirect("./store.php?action=error&error=1");
	}
	$response = $emcurl->getRespone();
	$ret = json_decode($response, 1);
	if (empty($ret)) {
		emDirect("./store.php?action=error&error=1");
	}
	if ($ret['code'] === MSGCODE_EMKEY_INVALID) {
		Option::updateOption('emkey', '');
		$CACHE->updateCache('options');
		emDirect("./register.php?error_store=1");
	}

	$plugins = $ret['data']['plugins'] ?? [];

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
