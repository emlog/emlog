<?php
/**
 * links
 * @package EMLOG (www.emlog.net)
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

$Link_Model = new Link_Model();

if (empty($action)) {
	$links = $Link_Model->getLinks();
	include View::getView('header');
	require_once(View::getView('store'));
	include View::getView('footer');
	View::output();
}

if ($action === 'addon') {
	$source = isset($_GET['source']) ? trim($_GET['source']) : '';
	$source_type = isset($_GET['type']) ? trim($_GET['type']) : '';
	if (empty($source)) {
		exit('error');
	}

	$temp_file = emFecthFile(OFFICIAL_SERVICE_HOST . $source);
	if (!$temp_file) {
		exit('error_down');
	}

	$unzip_path = $source_type == 'tpl' ? '../content/templates/' : '../content/plugins/';
	$ret = emUnZip($temp_file, $unzip_path, $source_type);
	@unlink($temp_file);
	switch ($ret) {
		case 0:
			exit('succ');
		case 1:
		case 2:
			exit('error_dir');
		case 3:
			exit('error_zip');
	}
}
