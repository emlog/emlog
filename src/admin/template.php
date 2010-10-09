<?php
/**
 * 模板管理
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

require_once 'globals.php';

if($action == '') {
	$nonce_templet = Options::get('nonce_templet');
	$nonceTplData = implode('', @file(TPLS_PATH.$nonce_templet.'/header.php'));
	preg_match("/Template Name:(.*)/i", $nonceTplData, $tplName);
	preg_match("/Author:(.*)/i", $nonceTplData, $tplAuthor);
	preg_match("/Description:(.*)/i", $nonceTplData, $tplDes);
	preg_match("/Author Url:(.*)/i", $nonceTplData, $tplUrl);
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

	include View::getView('header');
	require_once View::getView('template');
	include View::getView('footer');
	View::output();
}
//使用模板
if($action == 'usetpl')
{
	$tplName = isset($_GET['tpl']) ? addslashes($_GET['tpl']) : '';
	$tplSideNum = isset($_GET['side']) ? intval($_GET['side']) : '';

	Options::updateOption('nonce_templet', $tplName);
	Options::updateOption('tpl_sidenum', $tplSideNum);
	$CACHE->updateCache('options');
	header("Location: ./template.php?activated=true");
}
