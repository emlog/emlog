<?php
/**
 * 插件管理
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.1.0
 * $Id: plugin.php 900 2009-02-22 04:16:34Z emloog $
 */

require_once('globals.php');
require_once(EMLOG_ROOT.'/model/C_plugin.php');

if($action == '')
{
	$emPlugin = new emPlugin($DB);

	$plugins = $emPlugin->getPlugins();
	
	include getViews('header');
	require_once(getViews('plugin'));
	include getViews('footer');
	cleanPage();
}

if ($action== 'active')
{
	$plugin = isset($_POST['plugin']) ? $_POST['plugin'] : '';
	$id = isset($_POST['id']) ? $_POST['id'] : '';

	$emPlugin = new emPlugin($DB, $plugin);
	$emPlugin->active_plugin($active_plugins);
	$CACHE->mc_options();

	echo "<img src=\"./views/".ADMIN_TPL."/images/plugin_{$action}.gif\" onclick=\"do_plugin('$plugin', 'inactive', '$id');\" title=\"已激活\" align=\"absmiddle\">";
}

if($action== 'inactive')
{
	$plugin = isset($_POST['plugin']) ? $_POST['plugin'] : '';
	$id = isset($_POST['id']) ? $_POST['id'] : '';
	
	$emPlugin = new emPlugin($DB, $plugin);
	$emPlugin->inactive_plugin($active_plugins);
	$CACHE->mc_options();
	
	echo "<img src=\"./views/".ADMIN_TPL."/images/plugin_{$action}.gif\" onclick=\"do_plugin('$plugin', 'active', '$id');\" title=\"未激活\" align=\"absmiddle\">";
}

?>
