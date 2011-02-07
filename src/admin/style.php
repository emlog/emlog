<?php
/**
 * 基本设置
 * @copyright (c) Emlog All Rights Reserved
 * $Id: configure.php 1811 2011-01-29 05:56:38Z emloog $
 */

require_once 'globals.php';

if ($action == '') {
	$style_path = './views/style/';
	$handle = @opendir($style_path) OR die('emlog template path error!');
	$styles = array();
	while ($file = @readdir($handle))
	{
		if(file_exists($style_path.$file.'/style.css'))
		{
			$styleData = implode('', @file($style_path.$file.'/style.css'));
			preg_match("/Style Name:([^\r\n]+)/i", $styleData, $name);
			$styleInfo['style_name'] = !empty($name[1]) ? trim($name[1]) : $file;
			$styleInfo['style_file'] = $file;

			$styles[] = $styleInfo;
		}
	}
	closedir($handle);
	$stylenums = count($styles);

	include View::getView('header');
	require_once(View::getView('style'));
	include View::getView('footer');
	View::output();
}

//update
if($action == 'usestyle')
{
	$styleName = isset($_GET['style']) ? addslashes($_GET['style']) : '';

	Option::updateOption('admin_style', $styleName);
	$CACHE->updateCache('options');
	header("Location: ./style.php?activated=true");
}
