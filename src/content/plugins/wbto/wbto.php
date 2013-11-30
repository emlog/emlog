<?php
/*
Plugin Name: 微博通
Version: 1.0
Plugin URL:
Description: 基于Wbto的API，可以将在emlog内发布的碎语、日志同步到指定的Wbto账号。
Author: 奇遇
Author Email: qiyuuu@gmail.com
Author URL: http://www.qiyuuu.com/
*/
!defined('EMLOG_ROOT') && exit('access deined!');

require_once 'wbto_profile.php';
require_once 'wbto_config.php';

function postBlog2Wbto($blogid) {
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

    $postData = 'content='.urlencode($t);
	$postData .= '&source=' . WBTO_API_KEY;

    wbto_httpRequestSocket($postData, WBTO_API_DOMAIN, WBTO_API_POST_PATH);
}

if (WBTO_SYNC == '3' || WBTO_SYNC == '1') {
    addAction('save_log', 'postBlog2Wbto');
}

function postTwitter2Wbto($t, $tid) {
	$DB = MySql::getInstance();
	$sql = "SELECT * FROM " . DB_PREFIX . "twitter WHERE id=$tid";
	$twitter = $DB->once_fetch_array($sql);
    $postData = 'content='.urlencode(stripcslashes($t));
    if (WBTO_TFROM == '4') {
        $postData = 'content='.urlencode(stripcslashes(subString($t, 0, 300)) . ' - 来自博客：' . BLOG_URL);
	}
	if(empty($twitter['img'])) {
		$postPath = WBTO_API_POST_PATH;
	} else {
		$postPath = WBTO_API_POST_IMAGE_PATH;
		$postData .= '&imgurl=' . urlencode(BLOG_URL . str_replace('thum-', '', $twitter['img']));
	}
	$postData .= '&source=' . WBTO_API_KEY;

    wbto_httpRequestSocket($postData, WBTO_API_DOMAIN, $postPath);
}
if (WBTO_SYNC == '2' || WBTO_SYNC == '1') {
    addAction('post_twitter', 'postTwitter2Wbto');
}
function wbto_menu() {
    echo '<div class="sidebarsubmenu" id="emlog_sinat"><a href="./plugin.php?plugin=wbto">微博通设置</a></div>';
}

addAction('adm_sidebar_ext', 'wbto_menu');
function wbto_httpRequestSocket($request, $host, $path, $port = 80) {
    $contentLength = strlen($request);
	$http_request  = "POST $path HTTP/1.1\r\n";
	$http_request .= "Host: $host\r\n";
	$http_request .= "Content-type: application/x-www-form-urlencoded\r\n";
	$http_request .= "Content-Length: $contentLength\r\n";
	$http_request .= "Authorization: Basic ".base64_encode(WBTO_USER_NAME . ':' . WBTO_USER_PASSWD)."\r\n";
	$http_request .= "User-Agent: wbto V1.0\r\n";
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
