<?php
/**
 * plugin management
 * @package EMLOG
 * @link https://www.emlog.net
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

$plugin = isset($_GET['plugin']) ? $_GET['plugin'] : '';

if (empty($action) && empty($plugin)) {
	$Plugin_Model = new Plugin_Model();
	$plugins = $Plugin_Model->getPlugins();

	include View::getAdmView('header');
	require_once(View::getAdmView('plugin'));
	include View::getAdmView('footer');
	View::output();
}

if ($action == 'active') {
	LoginAuth::checkToken();
	$Plugin_Model = new Plugin_Model();
	if ($Plugin_Model->activePlugin($plugin)) {
		$CACHE->updateCache('options');
		emDirect("./plugin.php?active=1");
	} else {
		emDirect("./plugin.php?active_error=1");
	}
}

if ($action == 'inactive') {
	LoginAuth::checkToken();
	$Plugin_Model = new Plugin_Model();
	$Plugin_Model->inactivePlugin($plugin);
	$CACHE->updateCache('options');
	emDirect("./plugin.php?inactive=1");
}

// Load plug-in configuration page
if (empty($action) && $plugin) {
	require_once "../content/plugins/{$plugin}/{$plugin}_setting.php";
	include View::getAdmView('header');
	plugin_setting_view();
	include View::getAdmView('footer');
}

// Save plug-in settings
if ($action == 'setting') {
	if (!empty($_POST)) {
		require_once "../content/plugins/{$plugin}/{$plugin}_setting.php";
		if (false === plugin_setting()) {
			emDirect("./plugin.php?plugin={$plugin}&error=1");
		} else {
			emDirect("./plugin.php?plugin={$plugin}&setting=1");
		}
	} else {
		emDirect("./plugin.php?plugin={$plugin}&error=1");
	}
}

if ($action == 'del') {
	LoginAuth::checkToken();
	$Plugin_Model = new Plugin_Model();
	$Plugin_Model->inactivePlugin($plugin);
	$Plugin_Model->rmCallback($plugin);
	$pludir = preg_replace("/^([^\/]+)\/.*/", "$1", $plugin);
	if (true === emDeleteFile('../content/plugins/' . $pludir)) {
		$CACHE->updateCache('options');
		emDirect("./plugin.php?activate_del=1");
	} else {
		emDirect("./plugin.php?error_a=1");
	}
}

if ($action == 'upload_zip') {
	LoginAuth::checkToken();
	$zipfile = isset($_FILES['pluzip']) ? $_FILES['pluzip'] : '';

	if ($zipfile['error'] == 4) {
		emDirect("./plugin.php?error_d=1");
	}
	if ($zipfile['error'] == 1) {
		emDirect("./plugin.php?error_g=1");
	}
	if (!$zipfile || $zipfile['error'] >= 1 || empty($zipfile['tmp_name'])) {
		emMsg('插件上传失败， 错误码：' . $zipfile['error']);
	}
	if (getFileSuffix($zipfile['name']) != 'zip') {
		emDirect("./plugin.php?error_f=1");
	}

	$ret = emUnZip($zipfile['tmp_name'], '../content/plugins/', 'plugin');
	switch ($ret) {
		case 0:
			emDirect("./plugin.php?activate_install=1#tpllib");
			break;
		case -1:
			emDirect("./plugin.php?error_e=1");
			break;
		case 1:
		case 2:
			emDirect("./plugin.php?error_b=1");
			break;
		case 3:
			emDirect("./plugin.php?error_c=1");
			break;
	}
}

if ($action === 'check_update') {
	$plugins = isset($_POST['plugins']) ? $_POST['plugins'] : [];

	$emcurl = new EmCurl();
	$post_data = [
		'emkey' => Option::get('emkey'),
		'apps'  => json_encode($plugins),
	];
	$emcurl->setPost($post_data);
	$emcurl->request('https://www.emlog.net/plugin/upgrade');
	$retStatus = $emcurl->getHttpStatus();
	if ($retStatus !== MSGCODE_SUCCESS) {
		Output::error('请求更新失败，可能是网络问题');
	}
	$response = $emcurl->getRespone();
	$ret = json_decode($response, 1);
	if (empty($ret)) {
		Output::error('请求更新失败');
	}
	if ($ret['code'] === MSGCODE_EMKEY_INVALID) {
		Output::error('请求更新失败，请完成注册');
	}

	Output::ok($ret['data']);
}

if ($action === 'upgrade') {
	$alias = isset($_GET['alias']) ? trim($_GET['alias']) : '';

	if (!Register::isRegLocal()) {
		emDirect("./plugin.php?error_i=1");
	}

	$temp_file = emFetchFile('https://www.emlog.net/plugin/down/' . $alias);
	if (!$temp_file) {
		emDirect("./plugin.php?error_h=1");
	}
	$unzip_path = '../content/plugins/';
	$ret = emUnZip($temp_file, $unzip_path, 'plugin');
	@unlink($temp_file);
	switch ($ret) {
		case 0:
			$Plugin_Model = new Plugin_Model();
			$Plugin_Model->upCallback($alias);
			emDirect("./plugin.php?activate_upgrade=1");
			break;
		case 1:
		case 2:
			emDirect("./plugin.php?error_b=1");
			break;
		case 3:
			emDirect("./plugin.php?error_d=1");
			break;
		default:
			emDirect("./plugin.php?error_e=1");
	}
}
