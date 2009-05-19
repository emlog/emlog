<?php
/**
 * 插件管理
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.2.0
 * $Id$
 */

require_once('globals.php');
require_once(EMLOG_ROOT.'/model/C_plugin.php');

$plugin = isset($_GET['plugin']) ? $_GET['plugin'] : '';

if($action == '' && !$plugin)
{
	$emPlugin = new emPlugin($DB);

	$plugins = $emPlugin->getPlugins();

	include getViews('header');
	require_once(getViews('plugin'));
	include getViews('footer');
	cleanPage();
}
//激活
if ($action == 'active')
{
	$emPlugin = new emPlugin($DB, $plugin);
	$emPlugin->active_plugin($active_plugins);
	$CACHE->mc_options();

	header("Location: ./plugin.php?active=true");
}
//禁用
if($action == 'inactive')
{
	$emPlugin = new emPlugin($DB, $plugin);
	$emPlugin->inactive_plugin($active_plugins);
	$CACHE->mc_options();
	
	header("Location: ./plugin.php?inactive=true");
}
//加载插件配置页面
if ($action == '' && $plugin)
{
	include getViews('header');
	require_once("../content/plugins/{$plugin}/{$plugin}_set.php");
	include getViews('footer');
}

?>
