<?php
/**
 * 模板管理
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-3.0.1
 * $Id$
 */

require_once('./globals.php');

if($action == '')
{
	//当前模板
	$tpl = @parse_ini_file($tpl_dir.$nonce_templet.'/tpl.ini');
	$tplName = isset($tpl['tplname']) ? $tpl['tplname'] : $nonce_templet;
	$tplAuthor = isset($tpl['author']) ? '作者：'.$tpl['author'] : '';
	$tplDes = isset($tpl['des']) ? $tpl['des'] : '';
	//模板列表
	$handle = @opendir($tpl_dir) OR die('emlog template path error!');
	$tpls = array();
	while ($file = @readdir($handle))
	{
		$tplfiles = $tpl_dir.$file.'/header.php';
		$tplinfo = @parse_ini_file($tpl_dir.$file.'/tpl.ini');
		if(@filesize($tplfiles) > 0)
		{
			$tplinfo['tplfile'] = $file;
			if(!isset($tplinfo['tplname']))
			{
				$tplinfo['tplname'] = $file;
			}
			if(!isset($tplinfo['sidebar']))
			{
				$tplinfo['sidebar'] = 1;
			}
			$tpls[] = $tplinfo;
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
if($action == 'usetpl')
{
	$tplName = isset($_GET['tpl']) ? addslashes($_GET['tpl']) : '';
	$tplSideNum = isset($_GET['side']) ? addslashes($_GET['side']) : '';

	$DB->query("UPDATE ".DB_PREFIX."options SET option_value='$tplName' where option_name='nonce_templet'");
	$DB->query("UPDATE ".DB_PREFIX."options SET option_value='$tplSideNum' where option_name='tpl_sidenum'");
	$CACHE->mc_options();
	header("Location: ./template.php?activated=true");
}

?>