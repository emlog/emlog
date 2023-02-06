<?php
/**
 * templates
 * @package EMLOG
 * @link https://www.emlog.net
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

if ($action === '') {
	$nonce_templet = Option::get('nonce_templet');
	$nonce_templet_data = @file(TPLS_PATH . $nonce_templet . '/header.php');

	$tpls = [];
	$handle = @opendir(TPLS_PATH) or die('emlog template path error!');
	$i = 1;
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
			'tplfile'    => $file,
			'tplname'    => !empty($tplName[1]) ? subString(strip_tags(trim($tplName[1])), 0, 16) : $file,
			'tplurl'     => !empty($tplUrl[1]) ? subString(strip_tags(trim($tplUrl[1])), 0, 75) : '',
			'tpldes'     => !empty($tplDes[1]) ? subString(strip_tags(trim($tplDes[1])), 0, 40) : '',
			'author'     => !empty($author[1]) ? subString(strip_tags(trim($author[1])), 0, 16) : '',
			'author_url' => !empty($authorUrl[1]) ? subString(strip_tags(trim($authorUrl[1])), 0, 75) : '',
		];

		if ($nonce_templet == $file) {
			$tpls[0] = $tplInfo;
		} else {
			$tpls[$i] = $tplInfo;
		}
		$i++;
	}
	ksort($tpls);
	closedir($handle);
	$tplnums = count($tpls);

	include View::getAdmView('header');
	require_once View::getAdmView('template');
	include View::getAdmView('footer');
	View::output();
}

if ($action === 'usetpl') {
	LoginAuth::checkToken();
	$tplName = isset($_GET['tpl']) ? addslashes($_GET['tpl']) : '';

	Option::updateOption('nonce_templet', $tplName);
	$CACHE->updateCache('options');
	emDirect("./template.php?activated=1");
}

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

if ($action === 'install') {
	include View::getAdmView('header');
	require_once View::getAdmView('template_install');
	include View::getAdmView('footer');
	View::output();
}

if ($action === 'upload_zip') {
	LoginAuth::checkToken();
	$zipfile = isset($_FILES['tplzip']) ? $_FILES['tplzip'] : '';

	if ($zipfile['error'] == 4) {
		emDirect("./template.php?error_d=1");
	}
	if ($zipfile['error'] == 1) {
		emDirect("./template.php?error_f=1");
	}
	if (!$zipfile || $zipfile['error'] > 0 || empty($zipfile['tmp_name'])) {
		emMsg('模板上传失败， 错误码：' . $zipfile['error']);
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
