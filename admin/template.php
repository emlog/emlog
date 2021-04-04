<?php
/**
 * 模板管理
 * @package EMLOG (www.emlog.net)
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

if ($action === '') {
	$nonce_templet = Option::get('nonce_templet');
	$nonceTplData = @implode('', @file(TPLS_PATH . $nonce_templet . '/header.php'));
	preg_match("/Template Name:(.*)/i", $nonceTplData, $tplName);
	preg_match("/Version:(.*)/i", $nonceTplData, $tplVersion);
	preg_match("/Author:(.*)/i", $nonceTplData, $tplAuthor);
	preg_match("/Description:(.*)/i", $nonceTplData, $tplDes);
	preg_match("/Author Url:(.*)/i", $nonceTplData, $tplUrl);
	preg_match("/ForEmlog:(.*)/i", $nonceTplData, $tplForEmlog);
	$tplName = !empty($tplName[1]) ? trim($tplName[1]) : $nonce_templet;
	$tplDes = !empty($tplDes[1]) ? $tplDes[1] : '';
	$tplVer = !empty($tplVersion[1]) ? $tplVersion[1] : '';
	$tplForEm = !empty($tplForEmlog[1]) ? '适用于emlog：' . $tplForEmlog[1] : '';

	if (isset($tplAuthor[1])) {
		$tplAuthor = !empty($tplUrl[1]) ? "作者：<a href=\"{$tplUrl[1]}\">{$tplAuthor[1]}</a>" : "作者：{$tplAuthor[1]}";
	} else {
		$tplAuthor = '';
	}

	//模板列表
	$handle = @opendir(TPLS_PATH) or die('emlog template path error!');
	$tpls = array();
	while ($file = @readdir($handle)) {
		if (@file_exists(TPLS_PATH . $file . '/header.php')) {
			$tplData = implode('', @file(TPLS_PATH . $file . '/header.php'));
			preg_match("/Template Name:([^\r\n]+)/i", $tplData, $name);
			preg_match("/Sidebar Amount:([^\r\n]+)/i", $tplData, $sidebar);
			$tplInfo['tplname'] = !empty($name[1]) ? trim($name[1]) : $file;
			$tplInfo['sidebar'] = !empty($sidebar[1]) ? (int)$sidebar[1] : 1;
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
if ($action === 'usetpl') {
	LoginAuth::checkToken();
	$tplName = isset($_GET['tpl']) ? addslashes($_GET['tpl']) : '';
	$tplSideNum = isset($_GET['side']) ? (int)$_GET['side'] : '';

	Option::updateOption('nonce_templet', $tplName);
	Option::updateOption('tpl_sidenum', $tplSideNum);
	$CACHE->updateCache('options');
	emDirect("./template.php?activated=1");
}

//删除模板
if ($action === 'del') {
	LoginAuth::checkToken();
	$tplName = isset($_GET['tpl']) ? addslashes($_GET['tpl']) : '';

	$nonce_templet = Option::get('nonce_templet');
	if ($tplName === $nonce_templet) {
		emMsg('您不能删除正在使用的模板');
	}

	if (true === emDeleteFile(TPLS_PATH . $tplName)) {
		emDirect("./template.php?activate_del=1#tpllib");
	} else {
		emDirect("./template.php?error_f=1#tpllib");
	}
}

//安装模板
if ($action === 'install') {
	include View::getView('header');
	require_once View::getView('template_install');
	include View::getView('footer');
	View::output();
}

//上传zip模板
if ($action === 'upload_zip') {
	LoginAuth::checkToken();
	$zipfile = isset($_FILES['tplzip']) ? $_FILES['tplzip'] : '';

	if ($zipfile['error'] == 4) {
		emDirect("./template.php?error_d=1");
	}
	if (!$zipfile || $zipfile['error'] >= 1 || empty($zipfile['tmp_name'])) {
		emMsg('模板上传失败');
	}
	if (getFileSuffix($zipfile['name']) != 'zip') {
		emDirect("./template.php?error_a=1");
	}

	$ret = emUnZip($zipfile['tmp_name'], '../content/templates/', 'tpl');
	switch ($ret) {
		case 0:
			emDirect("./template.php?tpllib");
			break;
		case -2:
			emDirect("./template.php?error_e=1");
			break;
		case 1:
		case 2:
			emDirect("./template.php?error_b=1");
			break;
		case 3:
			emDirect("./template.php?error_c=1");
			break;
	}
}
