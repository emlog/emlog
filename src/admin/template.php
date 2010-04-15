<?php
/**
 * 模板管理
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.5.0
 * $Id$
 */

require_once 'globals.php';

if($action == '')
{
	//当前模板
	$tplData = implode('', @file(TPLS_PATH.$nonce_templet.'/header.php'));
	preg_match("/Template Name:(.*)/i", $tplData, $tplName);
	preg_match("/Author:(.*)/i", $tplData, $tplAuthor);
	preg_match("/Description:(.*)/i", $tplData, $tplDes);
	preg_match("/Author Url:(.*)/i", $tplData, $tplUrl);
	$tplName = !empty($tplName[1]) ? trim($tplName[1]) : $nonce_templet;
	$tplDes = !empty($tplDes[1]) ? $tplDes[1] : '';
	if(isset($tplAuthor[1]))
	{
		$tplAuthor = !empty($tplUrl[1]) ? "作者：<a href=\"{$tplUrl[1]}\">{$tplAuthor[1]}</a>" : "作者：{$tplAuthor[1]}";
	}else{
		$tplAuthor = '';
	}
	//模板列表
	$handle = @opendir(TPLS_PATH) OR die('emlog template path error!');
	$tpls = array();
	while ($file = @readdir($handle))
	{
		if(file_exists(TPLS_PATH.$file.'/header.php'))
		{
			$tplData = implode('', @file(TPLS_PATH.$file.'/header.php'));
			preg_match("/Template Name:([^\r\n]+)/i", $tplData, $name);
			preg_match("/Sidebar Amount:([^\r\n]+)/i", $tplData, $sidebar);
			$tplInfo['tplname'] = !empty($name[1]) ? trim($name[1]) : $file;
			$tplInfo['sidebar'] = !empty($sidebar[1]) ? intval($sidebar[1]) : 1;
			$tplInfo['tplfile'] = $file;

			$tpls[] = $tplInfo;
		}
	}
	closedir($handle);

	$tplnums = count($tpls);

	include getViews('header');
	require_once getViews('template');
	include getViews('footer');
	cleanPage();
}
//使用模板
if($action == 'usetpl')
{
	$tplName = isset($_GET['tpl']) ? addslashes($_GET['tpl']) : '';
	$tplSideNum = isset($_GET['side']) ? intval($_GET['side']) : '';

	updateOption('nonce_templet', $tplName);
	updateOption('tpl_sidenum', $tplSideNum);
	$CACHE->updateCache('options');
	header("Location: ./template.php?activated=true");
}
