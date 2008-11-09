<?php
/**
 * Widgets 侧边栏目管理
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.7.0
 * $Id: comment.php 654 2008-09-07 10:36:15Z emloog $
 */

require_once('./globals.php');


if($action == '')
{
	$widgets = unserialize($options_cache['sidebar']);
	$widgetsStr = implode(",", $widgets);
	
	include getViews('header');
	require_once(getViews('widgets'));
	include getViews('footer');
	cleanPage();
}

if($action == 'compages')
{
	$widgets = isset($_POST['widgets']) ? $_POST['widgets'] : array();
	
	$sidebar = serialize($widgets);
	$sql = "update ".DB_PREFIX."options set option_value='$sidebar' where option_name='sidebar'";
	$DB->query($sql);
	$CACHE->mc_options('options');
	formMsg("博客设置成功","./widgets.php",1);
}

?>