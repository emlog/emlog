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
	$widgets = @unserialize($options_cache['widgets']);
	$widgetTitle = @unserialize($options_cache['widget_title']);
	$custom_title = @unserialize($options_cache['custom_title']);
	$custom_content = @unserialize($options_cache['custom_content']);

	include getViews('header');
	require_once(getViews('widgets'));
	include getViews('footer');
	cleanPage();
}

if($action == 'compages')
{
	$widgets = isset($_POST['widgets']) ? serialize($_POST['widgets']) : array();
	$customTextTitle = isset($_POST['custom_title']) ? serialize($_POST['custom_title']) : array();
	$customTextContent = isset($_POST['custom_text']) ? serialize($_POST['custom_text']) : array();
	
	$DB->query("update ".DB_PREFIX."options set option_value='$widgets' where option_name='widgets'");
	$DB->query("update ".DB_PREFIX."options set option_value='$customTextTitle' where option_name='custom_title'");
	$DB->query("update ".DB_PREFIX."options set option_value='$customTextContent' where option_name='custom_content'");
	$CACHE->mc_options('options');
	formMsg("博客设置成功","./widgets.php",1);
}

?>