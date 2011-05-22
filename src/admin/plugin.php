<?php
/**
 * 插件管理
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
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
//禁用所有插件
if($action == 'reset') {
    Option::updateOption('active_plugins', 'a:0:{}');
	$CACHE->updateCache('options');
	emDirect("./plugin.php?inactive=true");
}
