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

	//模板列表
	$tpls = [];
	$handle = @opendir(TPLS_PATH) or die('emlog template path error!');
	while ($file = @readdir($handle)) {
		if (!file_exists(TPLS_PATH . $file . '/header.php')) {
			continue;
		}
		$tplData = implode('', @file(TPLS_PATH . $file . '/header.php'));
		preg_match("/Template Name:(.*)/i", $tplData, $tplName);
		preg_match("/Template Url:(.*)/i", $tplData, $tplUrl);
		preg_match("/Version:(.*)/i", $tplData, $tplVersion);
		preg_match("/Author:(.*)/i", $tplData, $author);
		preg_match("/Description:(.*)/i", $tplData, $tplDes);
		preg_match("/Author Url:(.*)/i", $tplData, $authorUrl);
		$tplInfo = [
			'tplfile' => $file,
			'tplname' => !empty($tplName[1]) ? subString(strip_tags(trim($tplName[1])), 0, 16) : $file,
			'tplurl'  => !empty($tplUrl[1]) ? subString(strip_tags(trim($tplUrl[1])), 0, 75) : '',
			'tpldes'  => !empty($tplDes[1]) ? subString(strip_tags(trim($tplDes[1])), 0, 40) : '',
			'author'  => !empty($author[1]) ? subString(strip_tags(trim($author[1])), 0, 16) : '',
			'author_url'  => !empty($authorUrl[1]) ? subString(strip_tags(trim($authorUrl[1])), 0, 75) : '',
		];
		$tpls[] = $tplInfo;
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

	Option::updateOption('nonce_templet', $tplName);
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
	$zipfile = $_FILES['tplzip'] ?? '';

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
