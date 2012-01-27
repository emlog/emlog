<?php
/**
 * 插件管理
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'globals.php';

$plugin = isset($_GET['plugin']) ? $_GET['plugin'] : '';

if($action == '' && !$plugin) {
	$Plugin_Model = new Plugin_Model();
	$plugins = $Plugin_Model->getPlugins();

	include View::getView('header');
	require_once(View::getView('plugin'));
	include View::getView('footer');
	View::output();
}

//激活
if ($action == 'active') {
	$Plugin_Model = new Plugin_Model();
	if ($Plugin_Model->activePlugin($plugin) ){
	    $CACHE->updateCache('options');
	    emDirect("./plugin.php?active=true");
	} else {
	    emDirect("./plugin.php?active_error=true");
	}
}

//禁用
if($action == 'inactive') {
	$Plugin_Model = new Plugin_Model();
	$Plugin_Model->inactivePlugin($plugin);
	$CACHE->updateCache('options');
	emDirect("./plugin.php?inactive=true");
}

//加载插件配置页面
if ($action == '' && $plugin) {
	include View::getView('header');
	require_once "../content/plugins/{$plugin}/{$plugin}_setting.php";
	plugin_setting_view();
	include View::getView('footer');
}

//保存插件设置
if ($action == 'setting') {
	if(!empty($_POST)) {
		require_once "../content/plugins/{$plugin}/{$plugin}_setting.php";
		if(false === plugin_setting()){
		    emDirect("./plugin.php?plugin={$plugin}&error=true");
		}else{
		    emDirect("./plugin.php?plugin={$plugin}&setting=true");
		}
	}else{
	    emDirect("./plugin.php?plugin={$plugin}&error=true");
	}
}

//安装插件
if ($action == 'install') {
	include View::getView('header');
	require_once View::getView('plugin_install');
	include View::getView('footer');
	View::output();
}

//删除插件
if($action == 'del')
{
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
	$zipfile = isset($_FILES['pluzip']) ? $_FILES['pluzip'] : '';

	if ($zipfile['error'] == 4){
		emDirect("./plugin.php?action=install&error_d=1");
	}
	if (!$zipfile || $zipfile['error'] >= 1 || empty($zipfile['tmp_name'])){
		emMsg('插件上传失败');
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
