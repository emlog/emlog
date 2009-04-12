<?php
/**
 * 插件管理
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.1.0
 * $Id: plugin.php 900 2009-02-22 04:16:34Z emloog $
 */

require_once('globals.php');
require_once(EMLOG_ROOT.'/model/C_plugin.php');

$emPlugin = new emPlugin($DB);

if($action == '')
{
	$plugins = $emPlugin->getPlugins();
	
	include getViews('header');
	require_once(getViews('plugin'));
	include getViews('footer');
	cleanPage();
}

if ($action== 'del_tb')
{

}

if($action== 'dell_all_tb')
{

}

?>
