<?php
/**
 * 模板管理
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.7.0
 * $Id$
 */

require_once('./globals.php');

if($action == '')
{
	$handle = @opendir($tpl_dir) OR die('emlog template path error!');
	$tpls = array();
	while ($file = @readdir($handle))
	{
		$tplfiles = $tpl_dir.$file.'/header.php';
		if(@filesize($tplfiles) > 0)
		{
			$tpls[] = $file;
		}
	}
	closedir($handle);

	$tplnums = count($tpls);

	include getViews('header');
	require_once(getViews('template'));
	include getViews('footer');
	cleanPage();
}
//使用模板
if($action=='usetpl')
{
	$tplname = isset($_GET['tplname']) ? addslashes($_GET['tplname']) : '';
	$DB->query("UPDATE ".DB_PREFIX."options SET option_value='$tplname' where option_name='nonce_templet'");
	$CACHE->mc_options('options');
	header("Location: ./template.php");
}

?>