<?php
/**
 * Template Management
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.3.0
 * $Id$
 */

require_once('globals.php');

if($action == '')
{
	//Current template 
	$template_path = '../'.TEMPLATE_PATH;
	$tplData = implode('', @file($template_path.$nonce_templet.'/header.php'));
	preg_match("/Template Name:(.*)/i", $tplData, $tplName);
	preg_match("/Author:(.*)/i", $tplData, $tplAuthor);
	preg_match("/Description:(.*)/i", $tplData, $tplDes);
	preg_match("/Author Url:(.*)/i", $tplData, $tplUrl);
	$tplName = !empty($tplName[1]) ? trim($tplName[1]) : $nonce_templet;
	$tplDes = !empty($tplDes[1]) ? $tplDes[1] : '';
	if(isset($tplAuthor[1]))
	{
		$tplAuthor = !empty($tplUrl[1]) ? $lang['author'].": <a href=\"{$tplUrl[1]}\">{$tplAuthor[1]}</a>" : $lang['author'].": {$tplAuthor[1]}";
	}else{
		$tplAuthor = '';
	}
	//Template List
	$handle = @opendir($template_path) OR die('emlog template path error!');
	$tpls = array();
	while ($file = @readdir($handle))
	{
		if(file_exists($template_path.$file.'/header.php'))
		{
			$tplData = implode('', @file($template_path.$file.'/header.php'));
			preg_match("/Template Name:(.*)/i", $tplData, $name);
			preg_match("/Sidebar Amount:(.*)/i", $tplData, $sidebar);
			$tplInfo['tplname'] = !empty($name[1]) ? trim($name[1]) : $file;
			$tplInfo['sidebar'] = !empty($sidebar[1]) ? intval($sidebar[1]) : 1;
			$tplInfo['tplfile'] = $file;
			
			$tpls[] = $tplInfo;
		}
	}
	closedir($handle);

	$tplnums = count($tpls);

	include getViews('header');
	require_once(getViews('template'));
	include getViews('footer');
	cleanPage();
}
//Using a template
if($action == 'usetpl')
{
	$tplName = isset($_GET['tpl']) ? addslashes($_GET['tpl']) : '';
	$tplSideNum = isset($_GET['side']) ? intval($_GET['side']) : '';

	$DB->query("UPDATE ".DB_PREFIX."options SET option_value='$tplName' where option_name='nonce_templet'");
	$DB->query("UPDATE ".DB_PREFIX."options SET option_value='$tplSideNum' where option_name='tpl_sidenum'");
	$CACHE->mc_options();
	header("Location: ./template.php?activated=true");
}

?>