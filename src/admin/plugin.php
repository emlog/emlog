<?php
/**
 * Plugin management
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'globals.php';

$plugin = isset($_GET['plugin']) ? $_GET['plugin'] : '';

if ($action == '' && !$plugin) {
	$Plugin_Model = new Plugin_Model();
	$plugins = $Plugin_Model->getPlugins();

	include View::getView('header');
	require_once(View::getView('plugin'));
	include View::getView('footer');
	View::output();
}

//Activate
if ($action == 'active') {
    LoginAuth::checkToken();
	$Plugin_Model = new Plugin_Model();
	if ($Plugin_Model->activePlugin($plugin) ) {
		$CACHE->updateCache('options');
		emDirect("./plugin.php?active=1");
	} else {
		emDirect("./plugin.php?active_error=1");
	}
}

//Disable
if ($action == 'inactive') {
    LoginAuth::checkToken();
	$Plugin_Model = new Plugin_Model();
	$Plugin_Model->inactivePlugin($plugin);
	$CACHE->updateCache('options');
	emDirect("./plugin.php?inactive=1");
}

//Load the plug-in configuration page
if ($action == '' && $plugin) {
	include View::getView('header');
	require_once "../content/plugins/{$plugin}/{$plugin}_setting.php";
	plugin_setting_view();
	include View::getView('footer');
}

//Save plug-in settings
if ($action == 'setting') {
	if (!empty($_POST)) {
		require_once "../content/plugins/{$plugin}/{$plugin}_setting.php";
		if (false === plugin_setting()) {
			emDirect("./plugin.php?plugin={$plugin}&error=1");
		} else{
			emDirect("./plugin.php?plugin={$plugin}&setting=1");
		}
	} else{
		emDirect("./plugin.php?plugin={$plugin}&error=1");
	}
}

//Install plug-in
if ($action == 'install') {
	include View::getView('header');
	require_once View::getView('plugin_install');
	include View::getView('footer');
	View::output();
}

//Delete Plugin
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

//Upload zipped plugin
if ($action == 'upload_zip') {
    LoginAuth::checkToken();
	$zipfile = isset($_FILES['pluzip']) ? $_FILES['pluzip'] : '';

	if ($zipfile['error'] == 4) {
		emDirect("./plugin.php?action=install&error_d=1");
	}
	if (!$zipfile || $zipfile['error'] >= 1 || empty($zipfile['tmp_name'])) {
/*vot*/		emMsg(lang('plugin_upload_error'));
	}
	if (getFileSuffix($zipfile['name']) != 'zip') {
		emDirect("./plugin.php?action=install&error_a=1");
	}

	$ret = emUnZip($zipfile['tmp_name'], '../content/plugins/', 'plugin');
	switch ($ret) {
		case 0:
			emDirect("./plugin.php?activate_install=1#tpllib");
			break;
		case -1:
			emDirect("./plugin.php?action=install&error_e=1");
			break;
		case 1:
		case 2:
			emDirect("./plugin.php?action=install&error_b=1");
			break;
		case 3:
			emDirect("./plugin.php?action=install&error_c=1");
			break;
	}
}
