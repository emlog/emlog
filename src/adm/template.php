<?php
/**
 * 模板管理
 * @copyright (c) 2008, Emlog All rights reserved.
 * @version emlog-2.5.0
 */

require_once('./globals.php');

if($action == '')
{
	include getViews('header');
	
	$row=$DB->fetch_array($DB->query("SELECT nonce_templet FROM ".$db_prefix."config"));
	$tplname = $row['nonce_templet'];

	//读取目录
	$handle=@opendir($tpl_dir) OR die('模板目录未找到！');
	while ($file = @readdir($handle))
	{
		$tplfiles = $tpl_dir.$file.'/header.php';
		if(@filesize($tplfiles)>0)
		$tpls[] = $file;
	}
	closedir($handle);
	$tplnums = count($tpls);
	require_once(getViews('template'));
	include getViews('footer');cleanPage();
}

//使用模板
if($action=='usetpl')
{
	$tplname = isset($_GET['tplname'])?addslashes($_GET['tplname']):'';
	$DB->query("UPDATE ".$db_prefix."config SET nonce_templet='$tplname' ");
	$MC->mc_config('../cache/config');
	formMsg("模板设置成功","./template.php",1);
}
?>