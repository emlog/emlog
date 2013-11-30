<?php
/*
Plugin Name: emlog to follow5
Version: 1.0
Plugin URL:
Description: 基于Follow5的API，可以将在emlog内发布的碎语、日志同步到指定的Follow5账号。
Author: 奇遇
Author Email: qiyuuu@gmail.com
Author URL: http://www.qiyuuu.com/
*/
!defined('EMLOG_ROOT') && exit('access deined!');

require_once 'emlog2f5_profile.php';
require_once 'emlog2f5_config.php';

function postBlog2Follow5($blogid) {
    global $title, $ishide, $action, $isurlrewrite;

    if('y' == $ishide) {//忽略写日志时自动保存
        return false;
    }
    if('edit' == $action) {//忽略编辑日志
        return false;
    }
    if('autosave' == $action && 'n' == $ishide) {//忽略编辑日志时异步保存
        return false;
    }

    $t = stripcslashes(trim($title)) . ' ' . Url::log($blogid);

    $postData = 'status='.urlencode($t);
	$postData .= '&api_key=' . FOLLOW5_API_KEY;
	$postData .= '&source=' . FOLLOW5_API_SOURSE;

    emlog2f5_httpRequestSocket($postData, FOLLOW5_API_DOMAIN, FOLLOW5_API_POST_PATH);
}

if (FOLLOW5_SYNC == '3' || FOLLOW5_SYNC == '1') {
    addAction('save_log', 'postBlog2Follow5');
}

function postTwitter2Follow5($t) {
    $postData = 'status='.urlencode(stripcslashes($t));
    if (FOLLOW5_TFROM == '4') {
        $postData = 'status='.urlencode(stripcslashes(subString($t, 0, 300)) . ' - 来自博客：' . BLOG_URL);
    }
	$postData .= '&api_key=' . FOLLOW5_API_KEY;
	$postData .= '&source=' . FOLLOW5_API_SOURSE;

    emlog2f5_httpRequestSocket($postData, FOLLOW5_API_DOMAIN, FOLLOW5_API_POST_PATH);
}
if (FOLLOW5_SYNC == '2' || FOLLOW5_SYNC == '1') {
    addAction('post_twitter', 'postTwitter2Follow5');
}
function emlog2f5_menu() {
    echo '<div class="sidebarsubmenu" id="emlog_sinat"><a href="./plugin.php?plugin=emlog2f5">Follow5同步设置</a></div>';
}

addAction('adm_sidebar_ext', 'emlog2f5_menu');
function emlog2f5_httpRequestSocket($request, $host, $path, $port = 80) {
    $contentLength = strlen($request);
	$http_request  = "POST $path HTTP/1.1\r\n";
	$http_request .= "Host: $host\r\n";
	$http_request .= "Content-type: application/x-www-form-urlencoded\r\n";
	$http_request .= "Content-Length: $contentLength\r\n";
	$http_request .= "Authorization: Basic ".base64_encode(FOLLOW5_USER_NAME . ':' . FOLLOW5_USER_PASSWD)."\r\n";
	$http_request .= "User-Agent: emlog2f5 V1.0\r\n";
    $http_request .= "Connection: close\r\n";
    $http_request .= "\r\n";
	$http_request .= $request;

	$response = '';
	if( false != ( $fs = @fsockopen($host, $port, $errno, $errstr, 10) ) ) {
		fwrite($fs, $http_request);
		while ( !feof($fs) )
			$response .= fgets($fs, 1160); // One TCP-IP packet
		fclose($fs);
		$response = explode("\r\n\r\n", $response, 2);
	}
	return $response; 
}