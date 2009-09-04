<?php
/**
 * Plugin management
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.3.0
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
//Activate
if ($action == 'active')
{
	$emPlugin = new emPlugin($DB, $plugin);
	$emPlugin->active_plugin($active_plugins);
	$CACHE->mc_options();

	header("Location: ./plugin.php?active=true");
}
//Deactivate
if($action == 'inactive')
{
	$emPlugin = new emPlugin($DB, $plugin);
	$emPlugin->inactive_plugin($active_plugins);
	$CACHE->mc_options();
	
	header("Location: ./plugin.php?inactive=true");
}
//Load the plug-in configuration page
if ($action == '' && $plugin)
{
	include getViews('header');
	require_once("../content/plugins/{$plugin}/{$plugin}_setting.php");
	plugin_setting_veiw();
	include getViews('footer');
}
//Save plug-in settings
if ($action == 'setting')
{
	if(!empty($_POST))
	{
		require_once("../content/plugins/{$plugin}/{$plugin}_setting.php");
		plugin_setting();
	}
	header("Location: ./plugin.php?plugin={$plugin}&setting=true");
}
