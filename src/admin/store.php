<?php
/**
 * 应用中心
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'globals.php';

if ($action == '') {
    $site_url_encode = rawurlencode(base64_encode(BLOG_URL));
	include View::getView('header');
	require_once(View::getView('store'));
	include View::getView('footer');
	View::output();
}

if ($action == 'instpl') {
    $source = isset($_GET['source']) ? trim($_GET['source']) : '';
    $source_type = 'tpl';
    $source_typename = '模板';
    $source_typeurl = '<a href="template.php">查看模板</a>';
    include View::getView('header');
    require_once(View::getView('store_install'));
    include View::getView('footer');
}

if ($action == 'insplu') {
    $source = isset($_GET['source']) ? trim($_GET['source']) : '';
    $source_type = 'plu';
    $source_typename = '插件';
    $source_typeurl = '<a href="plugin.php">查看插件</a>';
    include View::getView('header');
    require_once(View::getView('store_install'));
    include View::getView('footer');  
}

if ($action == 'addon') {
    $source = isset($_GET['source']) ? trim($_GET['source']) : '';
    $source_type = isset($_GET['type']) ? trim($_GET['type']) : '';
    if (empty($source)) {
        exit('error');
    }
	$source = 'http://www.emlog.net' . $source;
    $handle = fopen($source, "rb");
    if (FALSE === $handle) {
        exit('error_get');
    }
    $contents = '';
    while (!feof($handle)) {
      $contents .= fread($handle, 8192);
    }
    fclose($handle);

    $temp_file = tempnam('/tmp', 'emtemp_');
    $handle = fopen($temp_file, "wb");
    fwrite($handle, $contents);

    $unzip_path = $source_type == 'tpl' ? '../content/templates/' : '../content/plugins/';
	$ret = emUnZip($temp_file, $unzip_path, $source_type);
    if($ret === 0) {
        exit('succ');
    } else {
        exit('error_zip');
    }
}
