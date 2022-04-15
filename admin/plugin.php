<?php
/**
 * 插件管理
 * @package EMLOG
 * @link https://www.emlog.net
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

$plugin = $_GET['plugin'] ?? '';

if (empty($action) && empty($plugin)) {
	$Plugin_Model = new Plugin_Model();
	$plugins = $Plugin_Model->getPlugins();

	include View::getAdmView('header');
	require_once(View::getAdmView('plugin'));
	include View::getAdmView('footer');
	View::output();
}

//开启
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

//禁用
if ($action == 'inactive') {
	LoginAuth::checkToken();
	$Plugin_Model = new Plugin_Model();
	$Plugin_Model->inactivePlugin($plugin);
	$CACHE->updateCache('options');
	emDirect("./plugin.php?inactive=1");
}

//加载插件配置页面
if (empty($action) && $plugin) {
	require_once "../content/plugins/{$plugin}/{$plugin}_setting.php";
	include View::getAdmView('header');
	plugin_setting_view();
	include View::getAdmView('footer');
}

//保存插件设置
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

//删除插件
if ($action == 'del') {
	LoginAuth::checkToken();
	$Plugin_Model = new Plugin_Model();
	$Plugin_Model->inactivePlugin($plugin);
	$pludir = preg_replace("/^([^\/]+)\/.*/", "$1", $plugin);
	if (true === emDeleteFile('../content/plugins/' . $pludir)) {
		$CACHE->updateCache('options');
		emDirect("./plugin.php?activate_del=1");
	} else {
		emDirect("./plugin.php?error_a=1");
	}
}

//上传zip插件
if ($action == 'upload_zip') {
	LoginAuth::checkToken();
	$zipfile = $_FILES['pluzip'] ?? '';

	if ($zipfile['error'] === 4) {
		emDirect("./plugin.php?error_d=1");
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
